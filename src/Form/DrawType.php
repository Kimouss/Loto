<?php

namespace App\Form;

use App\Entity\Draw;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DrawType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbDraw')
            ->add('day')
            ->add('date')
            ->add('ball1')
            ->add('ball2')
            ->add('ball3')
            ->add('ball4')
            ->add('ball5')
            ->add('luckyBall')
            ->add('winComboAsc')
            ->add('nbWinRank1')
            ->add('amountRank1')
            ->add('nbWinRank2')
            ->add('amountRank2')
            ->add('nbWinRank3')
            ->add('amountRank3')
            ->add('nbWinRank4')
            ->add('amountRank4')
            ->add('nbWinRank5')
            ->add('amountRank5')
            ->add('nbWinRank6')
            ->add('amountRank6')
            ->add('nbWinRank7')
            ->add('amountRank7')
            ->add('nbWinRank8')
            ->add('amountRank8')
            ->add('nbWinRank9')
            ->add('amountRank9')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Draw::class,
        ]);
    }
}
