<?php

namespace Tourze\EasyAdminFileSizeFieldBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileSizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gb', NumberType::class, [
                'label' => 'GB',
                'required' => false,
                'attr' => [
                    'min' => 0,
                    'step' => 1,
                ],
            ])
            ->add('mb', NumberType::class, [
                'label' => 'MB',
                'required' => false,
                'attr' => [
                    'min' => 0,
                    'step' => 1,
                ],
            ])
            ->add('kb', NumberType::class, [
                'label' => 'KB',
                'required' => false,
                'attr' => [
                    'min' => 0,
                    'step' => 1,
                ],
            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $value = $event->getData();
            $form = $event->getForm();

            // 如果有值，将字节转换为GB、MB、KB
            if (is_numeric($value)) {
                $bytesValue = (int) $value;
                $gb = floor($bytesValue / (1024 * 1024 * 1024));
                $bytesValue -= $gb * 1024 * 1024 * 1024;
                $mb = floor($bytesValue / (1024 * 1024));
                $bytesValue -= $mb * 1024 * 1024;
                $kb = floor($bytesValue / 1024);

                $event->setData([
                    'gb' => $gb,
                    'mb' => $mb,
                    'kb' => $kb,
                ]);
            }
        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $data = $event->getData();

            // 计算总字节数
            if (is_array($data)) {
                $gb = isset($data['gb']) && is_numeric($data['gb']) ? (int) $data['gb'] : 0;
                $mb = isset($data['mb']) && is_numeric($data['mb']) ? (int) $data['mb'] : 0;
                $kb = isset($data['kb']) && is_numeric($data['kb']) ? (int) $data['kb'] : 0;

                $totalBytes = ($gb * 1024 * 1024 * 1024) + ($mb * 1024 * 1024) + ($kb * 1024);
                $event->setData($totalBytes);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => true,
            'label' => false,
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['row_attr'] = array_merge(
            $view->vars['row_attr'] ?? [],
            [
                'class' => 'easy-admin-file-size-row',
            ]
        );
    }
}
