<!-- side_nav.php -->
<div class="side-nav">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="detail.php">Details</a></li>
        <li><a href="edit.php">Edit</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<style>
.side-nav {
    width: 200px;
    background-color: #2c3e50;
    height: 100vh;
    padding-top: 20px;
    position: fixed;
}
.side-nav ul {
    list-style-type: none;
    padding: 0;
}
.side-nav ul li {
    padding: 10px;
}
.side-nav ul li a {
    color: white;
    text-decoration: none;
    display: block;
}
.side-nav ul li a:hover {
    background-color: #34495e;
}
</style>