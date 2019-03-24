# PHP-MySQLi Prepared Statement Cheatsheet
Dug up some reference code from my old PHP projects. Hopefully it's useful.

## Querying database (SELECT)

```php
$my_results = array();

$sql = "SELECT id, title, description, category from events";

// Assuming such function to get the mysqli connection object exists.
$conn = get_conn();

if ($query = $conn->prepare($sql)) {
	$query->execute();
	$query->bind_result($id, $title, $description, $category);

	while ($query->fetch()) {
		$data = array(
			"id" => (int)($id),
			"title" => $title,
			"description" => $description,
			"category" => $category,
		);

		// Store the results into an array for use later.
		array_push($my_results, $data);
	}

	// Close the query.
	$query->close();
}

// Close the connection.
$conn->close();


// Make use of our results from the database now.
if (count($my_results) !== 0) {
	foreach ($my_results as $row) {
		echo "ID: " . $row["id"];
		echo "Title: " . $row["title"];
		echo "Description" . $row["description"];
		echo "Category" . $row["category"];
	}
}

```

## Querying database with parameters (SELECT)

```php
$my_results = array();

// User input.
$category = "cycling";

// Do not concatenate the user input directly into the SQL query.
// NEVER TRUST USER INPUT. Prevents SQL injection.
$sql = "SELECT id, title, description from events WHERE category=?";

// Assuming such function to get the mysqli connection object exists.
$conn = get_conn();

if ($query = $conn->prepare($sql)) {
	// Bind the user input.
	$query->bind_param("s", $category);
	$query->execute();
	$query->bind_result($id, $title, $description);

	while ($query->fetch()) {
		$data = array(
			"id" => (int)($id),
			"title" => $title,
			"description" => $description,
		);

		// Store the results into an array for use later.
		array_push($my_results, $data);
	}

	// Close the query.
	$query->close();
}

// Close the connection.
$conn->close();


// Make use of our results from the database now.
if (count($my_results) !== 0) {
	foreach ($my_results as $row) {
		echo "ID: " . $row["id"];
		echo "Title: " . $row["title"];
		echo "Description" . $row["description"];
	}
}

```

## Inserting into database

```php
// User inputs.
$id = 5
$title = "YOLO Run";
$description = "Its back, bigger than before!";
$category = "running";

// Do not concatenate the user input directly into the SQL query.
// NEVER TRUST USER INPUT. Prevents SQL injection.
$sql = "INSERT INTO events (id, title, description, category) VALUES (?, ?, ?, ?)";

// Assuming such function to get the mysqli connection object exists.
$conn = get_conn();

if ($query = $conn->prepare($sql)) {
	// Bind the user input.
	$query->bind_param("isss", $id, $title, $description, $category);
	
	if (!$query->execute()) {
		// Something went wrong.
		echo "Failed to insert record into database: " . $query->error;
	}

	// Close the query.
	$query->close();
}

// Close the connection.
$conn->close();

```
