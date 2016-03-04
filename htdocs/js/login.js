function test_password(password) {
    var variations = {
        digits: /\d/.test(password),
        lower: /[a-z]/.test(password),
        upper: /[A-Z]/.test(password),
    }
    count = 0;
    for (var check in variations) {
        if (variations[check] == true) {
            count++;
        }
    }
    if (count < 2) {
        alert("Password needs to have at least 2 of the 3: digits, lowercase, uppercase letters");
        return 0;
    }
    if (password.length < 8) {
        alert("Password needs to have at least 8 characters");
        return 0;
    }
    return 1;
}
