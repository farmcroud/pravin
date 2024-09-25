document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('cardForm');
    const downloadCard = document.getElementById('downloadCard');
    const cardElement = document.getElementById('card'); // The card element to capture

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const name = document.getElementById('name').value;
        const profilePictureInput = document.getElementById('profilePicture');
        const profileImage = document.getElementById('profileImage');

        // Update the name on the card
        document.getElementById('userName').textContent = name;

        // If a profile picture is uploaded, update it on the card
        const file = profilePictureInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    downloadCard.addEventListener('click', () => {
        html2canvas(cardElement, { scale: 2 }).then(canvas => {
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/jpeg', 1.0); // High-quality JPEG
            link.download = 'profile-card.jpg';
            link.click();
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('cardForm');
    const cardElement = document.getElementById('card'); // The card element to capture

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(form);

        // Use html2canvas to capture the card as an image
        html2canvas(cardElement, { scale: 2 }).then(canvas => {
            // Convert canvas to image blob
            canvas.toBlob(function(blob) {
                formData.append('cardImage', blob, 'profile-card.jpg');

                // Send the form data including the card image to save_card.php
                fetch('save_card.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Handle success
                })
                .catch(error => {
                    console.error('Error:', error); // Handle error
                });
            }, 'image/jpeg');
        });
    });
});
