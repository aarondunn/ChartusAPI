# Chartus API reference #

The Chartus API URL is [https://chartus.org/api](https://chartus.org/api "Chartus API URL").

The interaction protocol is pretty simple.

You're sending the HTTP POST request with action name and action parameters and retrieving a response in JSON format.

----------

For example, the POST request to the Chartus API URL using PHP CURL with CURLOPT_POSTFIELDS equal to something like "action=someAction&param1=foo&param2=bar".

You can use, modify or extend provided Chartus API Client example, e.g. by adding new API actions into interface.

----------

API Limitation:

Currently we have limit: 3000 api requests per day for each Chartus user

----------

## Chartus API requests ##

1. getAuthToken - The action return user's authentication token
    Parameters:
        $login - user's login
        $password - user's password
    The API response contains user's token if user exists and the password is correct.
        The response example:
    {"auth_token":"iGM472YCcw6aLP4JWlSukOA10H9y8KzhX6gBjxoDbtrvZRsUEFe35QmqT7VnIdZY"}

2. getMyBooksCount - The action providing total number of the user's books.
    Parameters:
        $filter(optional) - filter for user books: reading, creating, none.
            Available values:
                0 - none (by default)
                1 - reading
                2 - creating
    The API response contains number of user's books.
        The response example:
        "14"

3. getMyBooks - The action providing the user's books.
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

4. searchBooksCount - The action providing total number of books that match the search query
	Parameters:
	    $search_request - search request.
        $genre - search by genre ID (all genres can be retrieved using getGenres action).

	Search in book title, description; chapter title, description, content;
    section title, description, content; author's first and last name; by genre ID

    The API response contains number of user's books that match the search query
        The response example:
        "7"

5. searchBooks - The action performing search in public books
	Parameters:
		$limit - how much books should be in a chunk (max. allowed value is 50).
		$offset - the offset from where count the books amount
			(can't be greater than the total books amount).
	    $search_request - search request.
	    $genre - search by genre ID (all genres can be retrieved using getGenres action).

	Search in book title, description; chapter title, description, content;
    section title, description, content; author's first and last name; by genre ID
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

6. getBooksCount - The action providing total number of public books
	Parameters:
	    no parameters

    The API response contains number of public books
        The response example:
        "22"

7. getBooks - The action returns all public books
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

8. getBook - The action returns book contents by book ID (with list of all chapters and sections)
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

9. getChaptersCount - The action providing total number of chapters for specified book
    Parameters:
        $book_id - book ID

        The API response contains total number of chapters for specified book
            The response example:
            "34"

10. getChapters - The action returns all the book chapters
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

11. getChapter - The action returns chapter by chapter ID
    Parameters:
        $id - chapter ID.

    The API response contains "Chapter" object.
        The response example:
        {"id":"122","title":"Testing #2","description":"ppp","content":"Test","position":"1", "sections_count":"10"}

12. getSectionsCount - The action providing total number of sections for specified chapter and parent section(optional)
    Parameters:
        $chapter_id - chapter ID
        $section_id - parent section ID(optional)

    Only parent sections count will be returned when $section_id is not specified.
    Otherwise sub-sections count will be returned.

    The API response contains total number of chapters for specified chapter and parent section(optional)
            The response example:
            "3"

13. getSections - The action returns all the book sections
    Parameters:
        $chapter_id - chapter ID
        $limit - how much sections should be in a chunk (max. allowed value is 50).
        $offset - the offset from where count the sections amount
            (can't be greater than the total sections amount).
        $section_id - parent section ID(optional)

    Only parent sections will be returned when $section_id is not specified.
    Otherwise sub-sections will be returned.

    For example, if the chapter has 30 sections, you can retrieve the sections from 5 to 15 by calling
    getSections action with $limit = 10 and $offset = 5.

    The API response contains an array of "Section" objects.
        The response example:
        [{"id":"111","title":"First chapter ","description":"Start","position":"1"},
         {"id":"112","title":"Second chapter ","description":"Start","position":"2"}]

14. getSection - The action returns section by section ID
    Parameters:
        $id - section ID.

    The API response contains "Section" object.
        The response example:
        {"id":"122","title":"Testing #2","description":"ppp","content":"Test","position":"1", "subsections_count":"3"}

15. getGenres - The action returns all genres
    Parameters:
        $limit - how much genres should be in a chunk (max. allowed value is 50).
        $offset - the offset from where count the genres amount
            (can't be greater than the total genres amount).

    The API response contains an array of "Genre" objects.
    books_count variable contains number of books that belong to that genre.
        The response example:
        [{"id":"1","title":"Music","icon":"music.png","books_count":"1"},{"id":"2","title":"Business","icon":"business.png","books_count":"5"}]

16. getGenresCount - The action providing total number of genres
    Parameters:
	    no parameters

    The API response contains total number of genres
            The response example:
            "30"

17. getUser - The action returns user details by user ID (or current user if User ID is not specified).
    Parameters:
        $id - user ID (optional).

    The API response contains "User" object.
        The response example:
        {"id":"110","url_name":"joe-johnes","email":"333@hhh.com","firstname":"Joe","lastname":"Johnes","create_time":"1338587100","occupation_id":"2",
            "occupation":{"title":"A Graduate Student","id":"2"},"profile":{"image":"http:\/\/chartus_profile.s3.amazonaws.com\/95_111111111111.jpg",
                "bio":"My bio here","homepage_url":"http:\/\/example.com","facebook_url":"http:\/\/google.com","linkedin_url":"http:\/\/example.com","education":"My edu here","user_id":"110"}}
