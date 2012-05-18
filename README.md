# Chartus API reference #

The Chartus API URL is [https://chartus.org/api](https://chartus.org/api "Chartus API URL").

The interaction protocol is pretty simple.

You're sending the HTTP POST request with action name and action parameters and retrieving a response in JSON format.

----------

For example, the POST request to the Chartus API URL using PHP CURL with CURLOPT_POSTFIELDS equal to something like "action=someAction&param1=foo&param2=bar".

You can use, modify or extend provided Chartus API Client example, e.g. by adding new API actions into interface.


## Chartus API requests ##

1. getMyBooks - The action providing the user's books.
	Parameters:
		$limit - how much books should be in a chunk (max. allowed value is 10).
		$offset - the offset from where count the books amount
			(can't be greater than the total books amount).
	    $filter(optional) - filter for user books: reading, creating, none.
            Available values:
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

2. searchBooks - The action performing search in public books
	Parameters:
		$limit - how much books should be in a chunk (max. allowed value is 10).
		$offset - the offset from where count the books amount
			(can't be greater than the total books amount).
	    $search_query - search query.
	Search in book title, description; chapter title, description, content;
    section title, description, content; author's first and last name
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

3. getBooks - The action returns all public books
	Parameters:
		$limit - how much books should be in a chunk (max. allowed value is 10).
		$offset - the offset from where count the books amount
			(can't be greater than the total books amount).
	    $search_query - search query.
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

4. getBook - The action returns book by ID
	Parameters:
	    $id - book ID.
    The API response contains an array of book data.
        The response example:
        {"id": 73, "title": "The Title Of Another Book", "description": "Some different description",
            "chapters":[{"id":"7","title":"Chapter1","description":"test",
                "sections":[{"id":"7","title":"MySection1","description":"test"},
                            {"id":"7","title":"MySection2","description":"test"}]}
            ],
            "genre":{"id":"7","title":"Law","icon":"law.png"}
        }