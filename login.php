<?php require_once 'header.php'; 

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<main style="display:flex; flex-direction:column; align-items:center; width:100%; max-width:500px; margin:0 auto; padding:40px 20px; gap:30px; flex:1;">
    <h2 style="font-size:3.5rem;">Member Login</h2>
    
    <form method="POST" style="width:100%; border:2px solid #1a1a1a; border-radius:30px; box-shadow:8px 8px 0px #1a1a1a; background-color:#f7f3e8; padding:40px; display:flex; flex-direction:column; gap:25px;">
        <?php if($error): ?>
            <div style="background:#ff6b6b; color:#fff; padding:15px; border-radius:12px; border:2px solid #1a1a1a; font-size:1.6rem; text-align:center;">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <div style="display:flex; flex-direction:column; gap:8px;">
            <label style="font-size:1.8rem; font-weight:bold;">Username</label>
            <input type="text" name="username" required style="padding:15px; border:2px solid #1a1a1a; border-radius:12px; font-size:1.6rem; background:#fff; box-shadow:2px 2px 0px #1a1a1a;">
        </div>

        <div style="display:flex; flex-direction:column; gap:8px;">
            <label style="font-size:1.8rem; font-weight:bold;">Password</label>
            <input type="password" name="password" required style="padding:15px; border:2px solid #1a1a1a; border-radius:12px; font-size:1.6rem; background:#fff; box-shadow:2px 2px 0px #1a1a1a;">
        </div>

        <button type="submit" class="pay-safe-btn" style="margin-top:10px;">Login</button>
        
        <p style="text-align:center; font-size:1.4rem; color:#555;">Demo Admin: <strong>admin</strong> / <strong>admin123</strong></p>
    </form>
</main>
<?php include 'footer.php'; ?>
