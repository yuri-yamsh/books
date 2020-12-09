<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route("/api")
 */
class AuthorController extends AbstractApiController
{
    use ValidationRequestTrait;

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/author/create", name="author_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $constraint = new Assert\Collection([
            'name' => [new Assert\Required(), new Assert\NotBlank(), new Assert\NotEqualTo('undefined')]
        ]);

        $errors = $this->validateRequest($request, $constraint);

        if (count($errors) > 0) {
            return $this->errorResponse('Ошибка валидации', $errors);
        }

        $author = new Author();
        $author->setName($request->get('name'));

        $this->em->persist($author);
        $this->em->flush();

        return $this->successResponse('Автор добавлен', ['id' => $author->getId()], 201);
    }
}
