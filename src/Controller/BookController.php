<?php

namespace App\Controller;

use App\Entity\Book;
use App\Enums\BookLanguagesEnum;
use App\Resources\BookCollection;
use App\Services\BookService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route("api")
 */
class BookController extends AbstractApiController
{
    use ValidationRequestTrait;

    private EntityManagerInterface $em;
    private BookService $bookService;

    public function __construct(
        EntityManagerInterface $em,
        BookService $bookService
    ) {
        $this->em = $em;
        $this->bookService = $bookService;
    }

    /**
     * Create the books.
     *
     * @Route("/book/create", name="book_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $constraint = new Assert\Collection([
            'name' => [new Assert\Required(), new Assert\NotBlank()],
            'author' => [new Assert\Required(), new Assert\NotBlank(), new Assert\Length(['min' => 1])]
        ]);

        $errors = $this->validateRequest($request, $constraint);

        if (count($errors) > 0) {
            return $this->errorResponse('Ошибка валидации', $errors);
        }

        $book = $this->bookService->create($request->get('name'), $request->get('author'));

        return $this->successResponse('Книга добавлена', ['id' => $book->getId()], 201);
    }

    /**
     * @Route(
     *     "/{lang}/book/{id}",
     *     requirements={
     *         "lang": "ru|en",
     *         "id": "\d+",
     *     },
     *     methods={"GET"}
     * )
     *
     */
    public function getByLang(string $lang, int $id): JsonResponse
    {
        /** @var Book $book */
        $book = $this->em->find(Book::class, $id);

        if (null === $book) {
            throw new NotFoundHttpException();
        }

        $bookLanguage = new BookLanguagesEnum($lang);

        $translationsArray = $book->getTranslationsByLang($bookLanguage);

        $bookId = ['id' => $book->getId()];
        $bookFields = array_merge($bookId, $translationsArray);

        return $this->successResponse("Книга на языке $lang", $bookFields);
    }

    /**
     * @Route("/book/search", name="book_search", methods={"GET"})
     *
     */
    public function search(Request $request)
    {
        $bookName = $request->query->get('name');

        $bookRepository = $this->em->getRepository(Book::class);

        $collection = $bookRepository->search($bookName);

        return $this->successResponse("Книги с названием $bookName", (new BookCollection($collection))->toArray());
    }
}
