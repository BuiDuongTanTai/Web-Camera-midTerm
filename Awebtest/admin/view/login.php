<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="view/css/style.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="index.php?act=login" class="mt-5">
            <table class="table table-bordered">
                <tr>
                    <td colspan="2"><h2 class="text-center">Admin Login</h2></td>
                </tr>
                <tr>
                    <td>Tên đăng nhập</td>
                    <td><input type="text" name="username" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Mật khẩu</td>
                    <td><input type="password" name="password" class="form-control" required></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        <input name="btn_submit" type="submit" class="btn btn-primary" value="Login">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>