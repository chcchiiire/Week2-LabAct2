<?php
class Book {
    public $title;
    protected $author;
    private $price;

    public function __construct($title, $author, $price) {
        $this->title = $title;
        $this->author = $author;
        $this->setPrice($price);
    }

    public function getDetails() {
        return "Title: {$this->title}, Author: {$this->author}, Price: \${$this->price}";
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function __call($name, $arguments) {
        if ($name === 'updateStock') {
            return "Stock updated for '{$this->title}' with arguments: " . implode($arguments);
        }
        return "Method {$name} does not exist.";
    }
}

class Library {
    private $books = [];
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    public function removeBook($title) {
        foreach ($this->books as $key => $book) {
            if ($book->title === $title) {
                unset($this->books[$key]);
                return "Book '{$title}' removed from the library.";
            }
        }
        return "Book '{$title}' not found.";
    }

    public function listBooks() {
        if (empty($this->books)) {
            return "No books in the library.";
        }
        $details = [];
        foreach ($this->books as $book) {
            $details[] = $book->getDetails();
        }
        return implode("<br>", $details);
    }

    public function __destruct() {
        echo "The library '{$this->name}' is now closed.";
    }
}

$library = new Library("City Library");
$book1 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 12.99);
$book2 = new Book("1984", "George Orwell", 8.99);
$library->addBook($book1);
$library->addBook($book2);
echo $book1->updateStock(50) . "<br>";
echo "Books in the Library:<br>";
echo $library->listBooks() . "<br>";
echo $library->removeBook("1984") . "<br>";
echo "Books in the Library after removal:<br>";
echo $library->listBooks() . "<br>";
unset($library);
?>
