<?php
    session_start();
    if (!@$_SESSION['admin_id']) {
        header('location: login.php');
    }
    include_once 'component/head.php';
    include_once '../api/editor/check.php';
?>
<!DOCTYPE html>
<html>

<head>
    <?php head('Quản lý thành viên | Gud News'); ?>
</head>

<body>
    <div class="container">
        <?php include_once 'component/sidebar.php'; ?>
        <div class="row">
            <?php include_once 'component/navbar.php'; ?>
            <div class="post-detail">
                <div class="main-post" style="margin: 0">
                    <h3>Danh sách thành viên</h3>
                    <table id="editor"></table>
                </div>
            </div>
            
            <?php include_once '../views/component/footer.php'; ?>
        </div>
    </div>
    <script>

        function get_list_member() {
            fetch('../api/member/read.php', {
                method: 'POST', 
                headers: {
                'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                var editor = document.getElementById('editor');
                editor.innerHTML = '';
                editor.insertAdjacentHTML('beforeend',"<tr id='title'><th>Họ tên</th><th>Email</th><th id='like'>Tuỳ chọn</th></tr>");
                for (a of data.result) {
                    editor.insertAdjacentHTML('beforeend',"<tr><td>"+a.name+"</td><td>"+a.email+"</td><td><button onclick='lock_member("+a.id+")' class='button-delete'>"+a.status+"</button></td></tr>");
                }
            })
            .catch((error) => {
              console.error('Error:', error);
            });
        }

        function lock_member(_id) {
            fetch('../api/member/delete.php', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                },
                body: JSON.stringify({id: _id})
            })
            .then(response => response.json())
            .then(data => {
                get_list_member                                          ();
            })
            .catch((error) => {
              console.error('Error:', error);
            });
        }

        get_list_member();
        document.getElementById('user-sidebar').classList.add('active');
    </script>
</body>

</html>