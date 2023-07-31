const params = new URLSearchParams(window.location.search); //Get query string
var pageType = (params.get('type'));

var closeButton         = document.getElementById('close');
var popupBlackout       = document.getElementById('popup-blackout');
var popupYesButton      = document.getElementById('popup-yes');
var popupNoButton       = document.getElementById('popup-no');

closeButton.addEventListener('click', function() {
    popupClose();
})

// Logout button
var logoutButton = document.getElementById('logout');
logoutButton.addEventListener('click', function() {
    var title = 'Logout';
    var message = 'Are you sure you want to logout of your account?';
    var location  = './?session=false';
    popup(title, message, location);
})


// Account page scripts
if (pageType == 'account') {

    // Delete account section
    var deleteAccountButton = document.getElementById('delete-account');
    deleteAccountButton.addEventListener('click', function() {
        var title = 'Delete Account!';
        var message = 'Are you sure you want to delete your account? This will delete your account and all your votes.';
        var location  = './delete-account.php';
        popup(title, message, location);
    })
}

if (pageType == 'config') {
    // Collapsing config sections
    var toggle = document.querySelectorAll('.toggle');
    toggle.forEach(element => {
        element.addEventListener('click', function() {
            element.nextElementSibling.classList.toggle('collapsed');
        })
    });
    

}






function popupClose() {
    popupBlackout.style.display = "none";
}

function popup(title, message, location) {
    var popupTitle = document.getElementById('popup-title');
    var popupMessage = document.getElementById('popup-message');
    popupTitle.innerText = title;
    popupMessage.innerText = message;
    popupBlackout.style.display = "flex";

    popupYesButton.onclick = function() {
        window.location = location;
    }

    popupNoButton.onclick = function() {
        popupClose();
    }
}