# Chartus API reference #

The Chartus API URL is [https://chartus.org/api](https://chartus.org/api "Chartus API URL").

The interaction protocol is pretty simple.

You're sending the HTTP POST request with action name and action parameters and retrieving a response in JSON format.

----------

For example, the POST request to the Chartus API URL using PHP CURL with CURLOPT_POSTFIELDS equal to something like "action=someAction&param1=foo&param2=bar".

You can use, modify or extend provided Chartus API Client example, e.g. by adding new API actions into interface.


## Chartus API requests ##

1. getUserBooks - The action providing the user's books.
	Parameters:
	    $userID - user ID.
		$limit - how much books should be in a chunk (max. allowed value is 10).
		$offset - the offset from where count the books amount
			(can't be greater than the total books amount).
	For example, if the user has 30 books, you can retrieve the books from 5 to 15 by calling
	getMyBooks action with $limit = 10 and $offset = 5.

    The API response contains an array of "Book" objects.
        The response example:
        [
            {"id": 42, "title": "Some Book Title", "description": "Some description"},
            {"id": 73, "title": "The Title Of Another Book", "description": "Some different description"}
        ]

