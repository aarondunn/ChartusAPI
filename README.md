# Chartus API reference #

The Chartus API URL is [https://chartus.org/api](https://chartus.org/api "Chartus API URL").

The interaction protocol is pretty simple.

You're sending the HTTP POST request with action name and action parameters and retrieving a response in JSON format.

----------

For example, the POST request to the Chartus API URL using PHP CURL with CURLOPT_POSTFIELDS equal to something like "action=someAction&param1=foo&param2=bar".

You can use, modify or extend provided Chartus API Client example, e.g. by adding new API actions into interface.


## Chartus API requests ##

1. getMyBooksCount - The action providing total number of the user's books.
    Parameters:
        $filter(optional) - filter for user books: reading, creating, none.
            Available values:
                0 - none (by default)
                1 - reading
                2 - creating
    The API response contains number of user's books.
        The response example:
        "14"

2. getMyBooks - The action providing the user's books.
	Parameters:
		$limit - how much books should be in a chunk (max. allowed value is 50).
		$offset - the offset from where count the books amount
			(can't be greater than the total books amount).
	    $filter(optional) - filter for user books: reading, creating, none.
            Available $filter values:
                0 - none (by default)
                1 - reading
                2 - creating
	For example, if the user has 30 books, you can retrieve the books from 5 to 15 by calling
	getMyBooks action with $limit = 10 and $offset = 5.

    The API response contains an array of "Book" objects.
        The response example:
        [
            {"id": 42, "title": "Some Book Title", "description": "Some description",
                "genre":{"id":"7","title":"Law","icon":"law.png"}}},
            {"id": 73, "title": "The Title Of Another Book", "description": "Some different description",
                "genre":{"id":"7","title":"Law","icon":"law.png"}}}
        ]

3. searchBooksCount - The action providing total number of books that match the search query
	Parameters:
	    $search_request - search request.
	Search in book title, description; chapter title, description, content;
    section title, description, content; author's first and last name

    The API response contains number of user's books that match the search query
        The response example:
        "7"

4. searchBooks - The action performing search in public books
	Parameters:
		$limit - how much books should be in a chunk (max. allowed value is 50).
		$offset - the offset from where count the books amount
			(can't be greater than the total books amount).
	    $search_request - search request.
	Search in book title, description; chapter title, description, content;
    section title, description, content; author's first and last name
	For example, if there are 30 results, you can retrieve the books from 5 to 15 by calling
	searchBooks action with $limit = 10 and $offset = 5.

    The API response contains an array of "Book" objects.
        The response example:
        [
            {"id": 42, "title": "Some Book Title", "description": "Some description",
                "genre":{"id":"7","title":"Law","icon":"law.png"}}},
            {"id": 73, "title": "The Title Of Another Book", "description": "Some different description",
                "genre":{"id":"7","title":"Law","icon":"law.png"}}}
        ]

5. getBooksCount - The action providing total number of public books
	Parameters:
	    no parameters

    The API response contains number of public books
        The response example:
        "22"

6. getBooks - The action returns all public books
	Parameters:
		$limit - how much books should be in a chunk (max. allowed value is 50).
		$offset - the offset from where count the books amount
			(can't be greater than the total books amount).
	    $search_query - search query.
	For example, if there are 30 books, you can retrieve the books from 5 to 15 by calling
	getBooks action with $limit = 10 and $offset = 5.

    The API response contains an array of "Book" objects.
        The response example:
        [
            {"id": 42, "title": "Some Book Title", "description": "Some description",
                "genre":{"id":"7","title":"Law","icon":"law.png"}}},
            {"id": 73, "title": "The Title Of Another Book", "description": "Some different description",
                "genre":{"id":"7","title":"Law","icon":"law.png"}}}
        ]

7. getBook - The action returns book contents by book ID (with list of all chapters and sections).
	Parameters:
	    $id - book ID.
	To get content of chapters and sections use requests getChapter and getSection
    The API response contains an array of book data.
        The response example:
        {"id": 73, "title": "The Title Of Another Book", "description": "Some different description",
            "chapters":[{"id":"7","title":"Chapter1","description":"test",
                "sections":[{"id":"7","title":"MySection1","description":"test"},
                            {"id":"7","title":"MySection2","description":"test"}]}
            ],
            "genre":{"id":"7","title":"Law","icon":"law.png"}
        }

8. getChaptersCount - The action providing total number of chapters for specified book
    Parameters:
        $book_id - book ID

        The API response contains total number of chapters for specified book
            The response example:
            "34"

9. getChapters - The action returns all the book chapters
    Parameters:
        $limit - how much chapters should be in a chunk (max. allowed value is 50).
        $offset - the offset from where count the chapters amount
            (can't be greater than the total chapters amount).
        $book_id - book ID.
    For example, if the book has 30 chapters, you can retrieve the chapters from 5 to 15 by calling
    getChapters action with $limit = 10 and $offset = 5.

    The API response contains an array of "Chapter" objects.
        The response example:
        [{"id":"111","title":"First chapter ","description":"Start","position":"1"},
         {"id":"112","title":"Second chapter ","description":"Start","position":"2"}]

10. getChapter - The action returns chapter by chapter ID
    Parameters:
        $id - chapter ID.

    The API response contains "Chapter" object.
        The response example:
        {"id":"122","title":"Testing #2","description":"ppp","content":"Test","position":"1"}

11. getSectionsCount - The action providing total number of sections for specified chapter and parent section(optional)
    Parameters:
        $chapter_id - chapter ID
        $section_id - parent section ID(optional)

    Only parent sections count will be returned when $section_id is not specified.
    Otherwise sub-sections count will be returned.

    The API response contains total number of chapters for specified chapter and parent section(optional)
            The response example:
            "3"

12. getSections - The action returns all the book sections
    Parameters:
        $chapter_id - chapter ID
        $limit - how much chapters should be in a chunk (max. allowed value is 50).
        $offset - the offset from where count the chapters amount
            (can't be greater than the total chapters amount).
        $section_id - parent section ID(optional)

    Only parent sections will be returned when $section_id is not specified.
    Otherwise sub-sections will be returned.

    For example, if the chapter has 30 sections, you can retrieve the sections from 5 to 15 by calling
    getSections action with $limit = 10 and $offset = 5.

    The API response contains an array of "Section" objects.
        The response example:
        [{"id":"111","title":"First chapter ","description":"Start","position":"1"},
         {"id":"112","title":"Second chapter ","description":"Start","position":"2"}]

13. getSection - The action returns section by section ID
    Parameters:
        $id - section ID.

    The API response contains "Section" object.
        The response example:
        {"id":"122","title":"Testing #2","description":"ppp","content":"Test","position":"1"}

