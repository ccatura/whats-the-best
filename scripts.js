const params = new URLSearchParams(window.location.search); //Get query string
var pageType = (params.get('type'));

if (pageType == 'account') {
    var deleteAccount = document.getElementById('delete-account');
    deleteAccount.addEventListener('click', function() {
        alert('This will delete your account and all your votes.')
    })
}

