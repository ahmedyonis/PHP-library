<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./styles/UCP.css">
    <title>User controll pannel</title>
</head>
<body>
	<header id="header">
        <h1>User Control Panel</h1>
        <div class="header-content">
            <a href="main.php"><button class="btn btn-primary">Back to Main</button></a>
            <form method="post">
                <a href="main.php"><button class="btn btn-primary">log out</button></a>
            </form>
            
        </div>
    </header>

    <button class="toggle-btn" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar" id="sidebar">
    <div class="text-center mb-4">
        <h5 class="mt-2">User Data</h5>
        <hr>
    </div>

    </div>

    <div class="main-content" id="mainContent">
    <div class="container-fluid p-4">
        <h2 class="mb-4 text-center">user's books</h2>

        <table class="table table-striped table-hover book-table">
        <thead class="table-dark">
            <tr>
            <th scope="col">book name</th>
            <th scope="col">book description</th>
            <th scope="col">Return date</th>
            <th scope="col">-----</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            
            </tr>
        </tbody>
        </table>
    </div>
    </div>


    <footer id="footer">
        &copy; 2025 ITI Project
    </footer>
    <script src="./script/UCP.js"></script>
</body>
</html>