<?php

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\Form;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tourze\EasyAdminFileSizeFieldBundle\Form\FileSizeType;

class FileSizeTypeTest extends TestCase
{
    public function testBuildForm_addsExpectedFields(): void
    {
        $formBuilder = $this->getMockBuilder(FormBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        // PHPUnit 10不再支持withConsecutive，改用willReturnCallback
        $formBuilder->expects($this->exactly(3))
            ->method('add')
            ->willReturnCallback(function ($field, $type, $options) use ($formBuilder) {
                static $callIndex = 0;
                $expectedFields = [
                    ['gb', NumberType::class],
                    ['mb', NumberType::class],
                    ['kb', NumberType::class],
                ];

                $this->assertSame($expectedFields[$callIndex][0], $field);
                $this->assertSame($expectedFields[$callIndex][1], $type);
                $callIndex++;

                return $formBuilder;
            });

        // 模拟addEventListener方法
        $formBuilder->expects($this->exactly(2))
            ->method('addEventListener')
            ->willReturnCallback(function ($eventName, $listener) use ($formBuilder) {
                static $callIndex = 0;
                $expectedEvents = [
                    FormEvents::PRE_SET_DATA,
                    FormEvents::SUBMIT,
                ];

                $this->assertSame($expectedEvents[$callIndex], $eventName);
                $callIndex++;

                return $formBuilder;
            });

        $type = new FileSizeType();
        $type->buildForm($formBuilder, []);
    }

    public function testConfigureOptions(): void
    {
        $resolver = new OptionsResolver();
        $type = new FileSizeType();
        $type->configureOptions($resolver);

        $resolvedOptions = $resolver->resolve([]);

        $this->assertTrue($resolvedOptions['compound']);
        $this->assertFalse($resolvedOptions['label']);
    }

    public function testBuildView(): void
    {
        $view = new FormView();
        $view->vars['row_attr'] = ['data-test' => 'test'];

        $form = $this->createMock(FormInterface::class);

        $type = new FileSizeType();
        $type->buildView($view, $form, []);

        $this->assertArrayHasKey('class', $view->vars['row_attr']);
        $this->assertStringContainsString('easy-admin-file-size-row', $view->vars['row_attr']['class']);
        $this->assertArrayHasKey('data-test', $view->vars['row_attr']);
    }
}
