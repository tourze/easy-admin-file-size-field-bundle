<?php

declare(strict_types=1);

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\Form;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tourze\EasyAdminFileSizeFieldBundle\Form\FileSizeType;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;

/**
 * @internal
 */
#[CoversClass(FileSizeType::class)]
#[RunTestsInSeparateProcesses]
final class FileSizeTypeTest extends AbstractIntegrationTestCase
{
    protected function onSetUp(): void
    {
    }

    public function testBuildFormAddsExpectedFields(): void
    {
        $formBuilder = $this->getMockBuilder(FormBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        // PHPUnit 10不再支持withConsecutive，改用willReturnCallback
        $addCallIndex = 0;
        $formBuilder->expects($this->exactly(3))
            ->method('add')
            ->willReturnCallback(function ($field, $type, $options) use ($formBuilder, &$addCallIndex) {
                $expectedFields = [
                    ['gb', NumberType::class],
                    ['mb', NumberType::class],
                    ['kb', NumberType::class],
                ];

                $this->assertSame($expectedFields[$addCallIndex][0], $field);
                $this->assertSame($expectedFields[$addCallIndex][1], $type);
                ++$addCallIndex;

                return $formBuilder;
            })
        ;

        // 模拟addEventListener方法
        $eventCallIndex = 0;
        $formBuilder->expects($this->exactly(2))
            ->method('addEventListener')
            ->willReturnCallback(function ($eventName, $listener) use ($formBuilder, &$eventCallIndex) {
                $expectedEvents = [
                    FormEvents::PRE_SET_DATA,
                    FormEvents::SUBMIT,
                ];

                $this->assertSame($expectedEvents[$eventCallIndex], $eventName);
                ++$eventCallIndex;

                return $formBuilder;
            })
        ;

        $type = self::getService(FileSizeType::class);
        $type->buildForm($formBuilder, []);
    }

    public function testConfigureOptions(): void
    {
        $resolver = new OptionsResolver();
        $type = self::getService(FileSizeType::class);
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

        $type = self::getService(FileSizeType::class);
        $type->buildView($view, $form, []);

        $rowAttr = $view->vars['row_attr'];
        $this->assertIsArray($rowAttr);
        $this->assertArrayHasKey('class', $rowAttr);
        $this->assertIsString($rowAttr['class']);
        $this->assertStringContainsString('easy-admin-file-size-row', $rowAttr['class']);
        $this->assertArrayHasKey('data-test', $rowAttr);
    }
}
