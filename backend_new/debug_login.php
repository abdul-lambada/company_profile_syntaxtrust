<?php
require_once 'config/session.php';
require_once 'config/database.php';

echo "<h2>Debug Login System</h2>";

// 1. Cek koneksi database
try {
    $stmt = $pdo->query("SELECT 1");
    echo "✅ Database connection OK<br>";
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}

// 2. Cek tabel users
try {
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "✅ Tabel users ada<br>";
    echo "Kolom: ";
    foreach ($columns as $col) {
        echo $col['Field'] . " (" . $col['Type'] . ") ";
    }
    echo "<br>";
} catch (PDOException $e) {
    echo "❌ Tabel users tidak ada: " . $e->getMessage() . "<br>";
}

// 3. Cek data users
try {
    $stmt = $pdo->query("SELECT id, username, email, full_name, is_active FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($users) > 0) {
        echo "✅ Data users ditemukan: " . count($users) . " user<br>";
        foreach ($users as $user) {
            echo "- ID: " . $user['id'] . ", Username: " . $user['username'] . ", Email: " . $user['email'] . ", Full Name: " . $user['full_name'] . ", Active: " . $user['is_active'] . "<br>";
        }
    } else {
        echo "❌ Tidak ada data users<br>";
    }
} catch (PDOException $e) {
    echo "❌ Error membaca data users: " . $e->getMessage() . "<br>";
}

// 4. Cek password hash untuk admin
$test_email = 'admin@syntaxtrust.com';
try {
    $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE email = ?");
    $stmt->execute([$test_email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "✅ Password hash untuk admin@syntaxtrust.com: " . substr($user['password_hash'], 0, 20) . "...<br>";
        
        // Test password verification
        $test_password = 'password';
        if (password_verify($test_password, $user['password_hash'])) {
            echo "✅ Password verification OK<br>";
        } else {
            echo "❌ Password verification FAILED<br>";
        }
    } else {
        echo "❌ User admin@syntaxtrust.com tidak ditemukan<br>";
    }
} catch (PDOException $e) {
    echo "❌ Error cek password: " . $e->getMessage() . "<br>";
}

// 5. Cek PHP error log
if (ini_get('log_errors')) {
    echo "📋 PHP error log path: " . ini_get('error_log') . "<br>";
}

// 6. Test login query
$test_email = 'admin@syntaxtrust.com';
$test_password = 'password';
try {
    $stmt = $pdo->prepare("SELECT id, username, email, password_hash, full_name FROM users WHERE email = ? AND is_active = 1");
    $stmt->execute([$test_email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "✅ User ditemukan di database<br>";
        if (password_verify($test_password, $user['password_hash'])) {
            echo "✅ Password cocok<br>";
        } else {
            echo "❌ Password tidak cocok<br>";
            echo "Expected: admin123<br>";
            echo "Hash di DB: " . $user['password_hash'] . "<br>";
        }
    } else {
        echo "❌ User tidak ditemukan di database<br>";
    }
} catch (PDOException $e) {
    echo "❌ Error login query: " . $e->getMessage() . "<br>";
}

// 7. Cek database name yang aktif
try {
    $stmt = $pdo->query("SELECT DATABASE() as current_db");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "📋 Database yang aktif: " . $result['current_db'] . "<br>";
} catch (PDOException $e) {
    echo "❌ Error cek database: " . $e->getMessage() . "<br>";
}

// 8. Cek versi MySQL
try {
    $stmt = $pdo->query("SELECT VERSION() as version");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "📋 MySQL versi: " . $result['version'] . "<br>";
} catch (PDOException $e) {
    echo "❌ Error cek versi: " . $e->getMessage() . "<br>";
}

// 9. Cek tabel yang ada
try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "📋 Tabel yang ada: " . implode(', ', $tables) . "<br>";
} catch (PDOException $e) {
    echo "❌ Error cek tabel: " . $e->getMessage() . "<br>";
}

// 10. Test insert dummy user untuk debug
/*
try {
    $dummy_password = password_hash('test123', PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute(['Test User', 'test@example.com', $dummy_password]);
    echo "✅ Dummy user inserted<br>";
} catch (PDOException $e) {
    echo "❌ Error insert dummy: " . $e->getMessage() . "<br>";
}
*/

echo "<hr><a href='login.php'>Kembali ke Login</a>";
?>
