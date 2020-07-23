<?php

namespace model;

class BooksDAO extends AbstractDAO
{

    protected function setTable()
    {
        $this->table = 'books';
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getById(int $id): array
    {
        $params = [
            'id' => $id
        ];
        $query = "
            SELECT
                b.id,
                b.name,
                b.isbn,
                b.description,
                b.image
            FROM
                books AS b
            WHERE
                b.id = :id;
        ";
        return $this->fetchAssoc($query, $params);
    }
}