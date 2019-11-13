<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text_body')
            ->add('customer_coment')
            ->add('user_id')
            ->add('is_open')
             /*
             ->add('is_public')
             ->add('is_in_progress')
            ->add('agent_coment')
            ->add('is_waiting_for_feedback')
            ->add('is_escalated')
            ->add('relation')
             */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
