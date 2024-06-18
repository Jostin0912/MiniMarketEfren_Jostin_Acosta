document.getElementById('productForm').addEventListener('submit', function (e) {
    let valid = true;

    const name = document.getElementById('name').value;
    const price = document.getElementById('price').value;
    const quantity = document.getElementById('quantity').value;

    // Validación del nombre
    if (!name) {
        document.querySelector('#name + .text-red-600').innerText = 'El nombre es obligatorio';
        valid = false;
    } else {
        document.querySelector('#name + .text-red-600').innerText = '';
    }

    // Validación del precio
    if (price <= 0 || isNaN(price)) {
        document.querySelector('#price + .text-red-600').innerText = 'El precio debe ser un número positivo';
        valid = false;
    } else {
        document.querySelector('#price + .text-red-600').innerText = '';
    }

    // Validación de la cantidad
    if (quantity < 0 || isNaN(quantity)) {
        document.querySelector('#quantity + .text-red-600').innerText = 'La cantidad debe ser un número no negativo';
        valid = false;
    } else {
        document.querySelector('#quantity + .text-red-600').innerText = '';
    }

    if (!valid) {
        e.preventDefault();
    }
});
