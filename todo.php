<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://bootswatch.com/flatly/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>       
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="assets/css/styles.css?v=2" />
  <style>
    #todoList li, #doneList li {
      cursor: default;
      margin-bottom: 8px;
      padding: 10px 12px;
      border-radius: 4px;
      background: #f8f9fa;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .btn-sm-custom {
      border: none;
      color: #fff;
      padding: 3px 8px;
      border-radius: 3px;
      margin-left: 5px;
      cursor: pointer;
    }
    .done-btn { background: #27ae60; }
    .remove-btn { background: #e74c3c; }
    .done-text { color: #7f8c8d; }
  </style>
</head>
<body>
<div class="boxy">
  <form class="form-inline" role="form">
    <div class="form-group">
      <input type="text" class="form-control" id="todo" placeholder="Add todo">
    </div>
    <button class="btn btn-primary" id="add-todo-button">ADD</button>
  </form>

  <br>

  <div class="well">
    <h4>Todo</h4>
    <ul id="todoList" class="listarea"></ul>
  </div>

  <div class="well">
    <h4>Done</h4>
    <ul id="doneList" class="listarea"></ul>
  </div>
</div>

<script>
$(document).ready(function() {
  loadLists();

  // Add new todo
  $('#add-todo-button').click(function(e) {
    e.preventDefault();
    const todoText = $('#todo').val().trim();
    if (todoText) {
      addTodoItem(todoText);
      $('#todo').val('').focus();
      saveLists();
    }
  });

  // Mark as done
  $(document).on('click', '.done-btn', function() {
    const li = $(this).closest('li');
    const text = li.find('span').text();
    li.remove();
    addDoneItem(text);
    saveLists();
  });

  // Remove from todo
  $(document).on('click', '#todoList .remove-btn', function() {
    $(this).closest('li').remove();
    saveLists();
  });

  // Remove from done
  $(document).on('click', '#doneList .remove-btn', function() {
    $(this).closest('li').remove();
    saveLists();
  });

  // Functions
  function addTodoItem(text) {
    $('#todoList').append(`
      <li>
        <span>${text}</span>
        <div>
          <button class="btn-sm-custom done-btn">Done</button>
          <button class="btn-sm-custom remove-btn">Remove</button>
        </div>
      </li>
    `);
  }

  function addDoneItem(text) {
    $('#doneList').append(`
      <li>
        <span class="done-text">${text}</span>
        <button class="btn-sm-custom remove-btn">Remove</button>
      </li>
    `);
  }

  function saveLists() {
    const todos = [];
    const done = [];
    $('#todoList li span').each(function() {
      todos.push($(this).text());
    });
    $('#doneList li span').each(function() {
      done.push($(this).text());
    });
    localStorage.setItem('todoList', JSON.stringify(todos));
    localStorage.setItem('doneList', JSON.stringify(done));
  }

  function loadLists() {
    const todos = JSON.parse(localStorage.getItem('todoList')) || [];
    const done = JSON.parse(localStorage.getItem('doneList')) || [];
    todos.forEach(addTodoItem);
    done.forEach(addDoneItem);
  }
});
</script>
</body>
</html>
