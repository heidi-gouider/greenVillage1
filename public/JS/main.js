document.addEventListener('DOMContentLoaded', function () {
    const passwordField = document.getElementById('passwordField');
    const confirmPasswordField = document.getElementById('confirmPasswordField');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    
    if (passwordField && togglePassword) {
        togglePassword.addEventListener('click', function () {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                togglePassword.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordField.type = 'password';
                togglePassword.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    }

    if (confirmPasswordField && toggleConfirmPassword) {
        toggleConfirmPassword.addEventListener('click', function () {
            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                toggleConfirmPassword.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                confirmPasswordField.type = 'password';
                toggleConfirmPassword.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    }
});
//     function togglePasswordVisibility(field, icon) {
//         if (field.type === 'password') {
//             field.type = 'text';
//             icon.classList.remove('bi-eye');
//             icon.classList.add('bi-eye-slash');
//         } else {
//             field.type = 'password';
//             icon.classList.remove('bi-eye-slash');
//             icon.classList.add('bi-eye');
//         }
//     }

//     togglePassword.addEventListener('click', function () {
//         togglePasswordVisibility(passwordField, togglePassword);
//     });

//     toggleConfirmPassword.addEventListener('click', function () {
//         togglePasswordVisibility(confirmPasswordField, toggleConfirmPassword);
//     });
// });
