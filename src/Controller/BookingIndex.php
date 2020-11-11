<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Booking;

class BookingIndex extends AbstractController
{
    /**
     * @Route("/create_booking", name="create_booking")
     */
    public function create_booking(Request $request)
    {
        $this->generateUrl('create_booking');
        $form = $this->createFormBuilder()
            ->add('firstName', TextType::class, ['required' => true])
            ->add('lastName', TextType::class, ['required' => true])
            ->add('phone', TextType::class, ['required' => true])
            ->add('email', TextType::class, ['required' => true])
            ->add('birthDate', DateType::class, ['required' => true, 'widget' =>'single_text'])
            ->add('startDate', DateType::class, ['required' => true, 'widget' =>'single_text'])
            ->add('endDate', DateType::class, ['required' => true, 'widget' =>'single_text'])
            ->add('arrivalTime', TimeType::class, ['required' => true, 'widget' =>'single_text'])
            ->add('nrOfPeople', IntegerType::class, ['required' => true])
            ->add('payingMethod', ChoiceType::class, ['choices' => ['cash'=>'cash','transfer'=>'transfer'],'required' => true])
            ->add('additionalInformation', TextareaType::class, ['required' => false, 'empty_data' =>'no additional information'])
            ->add('submit', SubmitType::class, ['label' => 'Create booking'])
            ->getForm();

        return $this->render('bookings/create_booking.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/bookings", name="bookings")
     */
    public function bookings()
    {
        $this->generateUrl('bookings');
        $repository = $this->getDoctrine()->getRepository(Booking::class);
        $bookings = $repository->findAll();
        return $this->render('bookings/list.html.twig',['bookings'=>$bookings]);
    }
}