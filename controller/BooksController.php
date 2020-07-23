<?php

namespace controller;

include_once "fileHandler.php";

use components\router\http\Request;
use exceptions\AuthorizationException;
use exceptions\InvalidArgumentException;
use exceptions\InvalidFileException;
use model\Books;
use model\BooksDAO;
use services\BooksService;


class BooksController extends AbstractController
{

    /**
     * @var BooksService
     */
    private $booksService;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->booksService = new BooksService();
    }

    public function create()
    {
        $postParams = $this->request->getPostParams();
        if (isset($postParams["create"])) {
            $error = false;
            $msg = "";
            if (!isset($postParams["name"]) || empty(trim($postParams["name"]))) {
                $msg = "Name is empty";
                $error = true;
            } elseif (!isset($postParams["isbn"]) || empty(trim($postParams["isbn"]))) {
                $msg = "ISBN is empty";
                $error = true;
            } elseif (!isset($postParams["description"]) || empty($postParams["description"])) {
                $msg = "Description is empty";
                $error = true;
            }
            if ($error) {

                include_once "view/create.php";

                echo $msg;
            } else {
                $this->booksService->upload($postParams);
            }
        } else {
            throw new InvalidArgumentException("Invalid arguments.");
        }
    }

    /**
     * @return void
     */
    public function getAll()
    {
        $booksDao = new BooksDAO();
        $books = $booksDao->findAll();

        include_once "view/main.php";
    }

    /**
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function getById()
    {
        $getParams = $this->request->getGetParams();
        if (isset($getParams['id'])) {
            $booksDao = new BooksDAO();
            $book = $booksDao->findBy($getParams);
        }

        if (empty($getParams['id'])) {
            throw new InvalidArgumentException("Invalid arguments.");
        }

        if (empty($book)) {
            throw new InvalidArgumentException("Invalid book.");
        }

        include_once "view/book.php";
    }

    /**
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function delete()
    {
        $getParams = $this->request->getGetParams();
        if (isset($getParams['id'])) {
            $booksDao = new BooksDAO();
            $book = $booksDao->findBy($getParams);
        }

        if (empty($book)) {
            throw new InvalidArgumentException("Invalid book.");
        }
        $params = [
            'id' => $getParams['id']
        ];
        $booksDao->delete($params);

        header('Location:/Bookstore/view/main');

        echo "Delete successful.";
    }

    /**
     * @param int|null $id
     *
     * @return void
     *
     * @throws AuthorizationException
     * @throws InvalidArgumentException
     */
    public function loadEdit($id=null)
    {
        $getParams = $this->request->getGetParams();
        if (isset($getParams['id'])) {
            $id = $getParams['id'];
        }
        if (empty($id)) {
            throw new InvalidArgumentException("Invalid arguments.");
        }
        $bookDao = new BooksDAO();
        $book = $bookDao->getById($id);
        if (empty($book)) {
            throw new InvalidArgumentException("Invalid book.");
        }

        include_once "view/editBook.php";
    }

    /**
     * @return void
     *
     * @throws AuthorizationException
     * @throws InvalidArgumentException
     * @throws InvalidFileException
     * @throws \exceptions\InvalidFileException
     */
    public function edit()
    {
        $postParams = $this->request->getPostParams();
        if (isset($postParams['edit'])) {
            $error = false;
            $msg = "";
            if (!isset($postParams["id"]) || empty($postParams["id"])) {
                throw new InvalidArgumentException("Invalid arguments.");
            } elseif (!isset($postParams["name"]) || empty(trim($postParams["name"]))) {
                $msg = "Name is empty";
                $error = true;
            } elseif (!isset($postParams["description"]) || empty(trim($postParams["description"]))) {
                $msg = "Description is empty";
                $error = true;
            } elseif (!isset($postParams["isbn"]) || empty($postParams["isbn"])) {
                $msg = "ISBN is empty";
                $error = true;
            }
            $bookDao = new BooksDAO();
            if ($error) {
                $book = $bookDao->getById($postParams["id"]);

                include_once "view/editBook.php";

                echo $msg;
            }
            if (!$error) {
                $bookDao = new BooksDAO();
                $getbook = $bookDao->getById(intval($postParams["id"]));
                if (empty($getbook)) {
                    throw new InvalidArgumentException("Invalid book.");
                }
                $book = new Books();
                $book->setId($postParams["id"]);
                $book->setName($postParams["name"]);
                $book->setDescription($postParams["description"]);
                $book->setIsbn($postParams["isbn"]);
                if (isset($_FILES["image"])) {
                    $book->setImage(uploadImage("image", $_SESSION["logged_user"]["full_name"]));
                }
                $params = [
                    'name'          => $book->getName(),
                    'isbn'          => $book->getIsbn(),
                    'description'   => $book->getDescription(),
                    'image'         => $book->getImage()
                ];
                $conditions = [
                    'id' => $book->getId()
                ];
                $bookDao->update($params, $conditions);

                header('Location:/Bookstore/view/main');

                echo "Edit successfull.";
            }
        } else {
            throw new InvalidArgumentException("Invalid arguments.");
        }
    }
}