function logout() {
            $.post("../php_calls/mail.php",
                {
                    action: "logout",
                },
            function(data) {
                if (data == 1) {
                    window.location.href ="/"; 
                }
            })
}
