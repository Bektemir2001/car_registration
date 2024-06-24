<?php

// src/Controller/CarController.php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\OwnerHistory;
use App\Form\CarType;
use App\Form\ReRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
	#[Route('/register', name: 'car_register')]
	public function register(Request $request, EntityManagerInterface $em)
	{
		$car = new Car();
		$form = $this->createForm(CarType::class, $car);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$car->setNumber(uniqid()); // Генерация уникального номера
			$em->persist($car);
			$em->flush();

			$history = new OwnerHistory();
			$history->setCar($car);
			$history->setOwnerName($car->getOwnerName());
			$history->setRegistrationDate(new \DateTime());
			$em->persist($history);
			$em->flush();

			return $this->redirectToRoute('car_list');
		}

		return $this->render('car/register.html.twig', [
			'form' => $form->createView(),
		]);
	}

	#[Route('/re-register', name: 'car_re_register')]
	public function reRegister(Request $request, EntityManagerInterface $em)
	{
		$form = $this->createForm(ReRegistrationType::class);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();
			$car = $em->getRepository(Car::class)->findOneBy(['number' => $data['number']]);

			if ($car) {
				$car->setOwnerName($data['ownerName']);
				$em->flush();

				$history = new OwnerHistory();
				$history->setCar($car);
				$history->setOwnerName($car->getOwnerName());
				$history->setRegistrationDate(new \DateTime());
				$em->persist($history);
				$em->flush();

				return $this->redirectToRoute('car_list');
			}
		}

		return $this->render('car/re_register.html.twig', [
			'form' => $form->createView(),
		]);
	}

	#[Route('/cars', name: 'car_list')]
	public function list(EntityManagerInterface $em)
	{
		$cars = $em->getRepository(Car::class)->findAll();
		return $this->render('car/list.html.twig', [
			'cars' => $cars,
		]);
	}

	#[Route('/car/{number}', name: 'car_history')]
	public function history($number, EntityManagerInterface $em)
	{
		$car = $em->getRepository(Car::class)->findOneBy(['number' => $number]);
		$history = $em->getRepository(OwnerHistory::class)->findBy(['car' => $car]);

		return $this->render('car/history.html.twig', [
			'car' => $car,
			'history' => $history,
		]);
	}

	#[Route('/models', name: 'car_models')]
	public function models(EntityManagerInterface $em)
	{
		$models = $em->getRepository(Car::class)->findAllModelsWithCount();
		return $this->render('car/models.html.twig', [
			'models' => $models,
		]);
	}
}
