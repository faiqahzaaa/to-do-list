<?php
// Path to the tasks file
$tasksFile = "tasks.txt";

// Function to get tasks from the file
function getTasks() {
    global $tasksFile;
    if (file_exists($tasksFile)) {
        return file($tasksFile, FILE_IGNORE_NEW_LINES);
    }
    return [];
}

// Function to add a new task to the file
function addTask($task) {
    global $tasksFile;
    $tasks = getTasks();
    $tasks[] = $task;
    file_put_contents($tasksFile, implode("\n", $tasks) . "\n");
}

// Function to delete a task from the file
function deleteTask($taskIndex) {
    global $tasksFile;
    $tasks = getTasks();
    unset($tasks[$taskIndex]);
    $tasks = array_values($tasks); // Reindex array
    file_put_contents($tasksFile, implode("\n", $tasks) . "\n");
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task']) && !empty($_POST['task'])) {
        addTask($_POST['task']);
    } elseif (isset($_POST['delete'])) {
        deleteTask($_POST['delete']);
    }
}

// Get all tasks
$tasks = getTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>My To-Do List</h1>

    <!-- Form to Add New Task -->
    <form method="POST">
        <input type="text" name="task" placeholder="Add a new task" required>
        <button type="submit">Add</button>
    </form>

    <!-- Display Tasks -->
    <ul>
        <?php foreach ($tasks as $index => $task): ?>
            <li>
                <?= htmlspecialchars($task) ?>
                <form method="POST" style="display:inline;">
                    <button type="submit" name="delete" value="<?= $index ?>">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
