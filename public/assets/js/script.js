let removeFavorite = function (projectid){
    const star = document.getElementsByClassName('fa-star');
    fetch('/admin/favorite', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            'project': projectid,
            'favorite': 0
        })
    })
        .then(response => response.json())
        .then(data => document.getElementById('favorite').classList.remove('star'), alert('C\'est bien noté: Ce n\'est plus un favoris!\n Vous avez changé d\'avis? Merci de recharger la page'))
}

let addFavorite = function (projectid) {
    const star = document.getElementsByClassName('fa-star');
    fetch('/admin/favorite', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            'project': projectid,
            'favorite': 1
        })
    })
        .then(response => response.json())
        .then(data => document.getElementById('favorite').classList.add('star'), alert('C\'est bien noté: C\'est un favoris!\n Vous avez changé d\'avis? Merci de recharger la page'))

}