// Open the modal with user information
function openModal(name, address, phone) {
    const modal = document.getElementById('orderModal');
    document.getElementById('modal-name').textContent = `Name: ${name}`;
    document.getElementById('modal-address').textContent = `Address: ${address}`;
    document.getElementById('modal-phone').textContent = `Phone: ${phone}`;
    modal.style.display = 'block';
}

// Close the modal
const modal = document.getElementById('orderModal');
const closeBtn = document.getElementsByClassName('close')[0];

closeBtn.onclick = function () {
    modal.style.display = 'none';
};

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};

// Confirmation before submission
function confirmOrder() {
    return confirm('Are you sure you want to place this order?');
}
