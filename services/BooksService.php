<?php

namespace services;

use exceptions\InvalidArgumentException;
use model\Books;
use model\BooksDAO;
use function controller\uploadImage;

class BooksService extends AbstractService
{
    protected function setDao()
    {
        $this->dao = new BooksDAO();
    }

    public function upload ($postParams)
    {
        $book = new Books();
        $book->setName($postParams["name"]);
        $book->setDescription($postParams["description"]);
        $book->setIsbn($postParams['isbn']);
        $book->setImage(uploadImage("image", $_SESSION["logged_user"]["first_name"]));
        $params = [
            'name'          => $book->getName(),
            'description'   => $book->getDescription(),
            'isbn'          => $book->getIsbn(),
            'image'         => $book->getImage()
        ];
        $booksDao = new BooksDAO();
        $book_id = $booksDao->insert($params);
        $book->setId($book_id);

        header('Location:/Bookstore/view/main');

        echo "Upload successfull.";
    }

}