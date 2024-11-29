$(document).ready(function () {

    function updateTotalPrice() {
        let grandTotal = 0;
        $('#orderTableBody tr').each(function () {
            grandTotal += parseFloat($(this).find('.totalPrice').text());
        });
        $('#grandTotal').text(grandTotal.toFixed(2));
    }

    function showMessage(message, type = 'danger') {
        const messageContainer = $('#messageContainer');
        messageContainer.removeClass('alert-danger alert-success').addClass(`alert alert-${type}`);
        messageContainer.text(message);
        messageContainer.show();
        setTimeout(() => {
            messageContainer.hide();
        }, 6000);
    }

    $('#add-more').click(function () {
        const selectedDropdown = $('#product-container select').last(); 
        const selectedProduct = selectedDropdown.val();
        const selectedProductPrice = selectedDropdown.find('option:selected').data('price');
        const selectedProductName = selectedDropdown.find('option:selected').text();
        const selectedProductImage = selectedDropdown.find('option:selected').data('image');

        if (!selectedProduct) {
            showMessage('Please select a product before clicking Add More.');
            return;
        }

        const existingRow = $('#orderTableBody').find(`tr[data-product-id="${selectedProduct}"]`);

        if (existingRow.length > 0) {
            // Increase quantity if the product already exists
            const quantityInput = existingRow.find('.quantity');
            const currentQuantity = parseInt(quantityInput.val());
            const newQuantity = currentQuantity + 1;
            quantityInput.val(newQuantity);

            const newTotalPrice = (newQuantity * selectedProductPrice).toFixed(2);
            existingRow.find('.totalPrice').text(newTotalPrice);
        } else {
            // Add new row if product does not exist
            const row = `
                <tr data-product-id="${selectedProduct}">
                    <td>${selectedProductName}</td>
                    <td><img src="${selectedProductImage}" alt="${selectedProductName}" width="100" height="100"></td>
                    <td>${selectedProductPrice}</td>
                    <td class="quantity-container">
                        <button type="button" class="btn btn-secondary btn-sm decreaseQty">-</button>
                        <input type="number" class="form-control quantity" value="1" min="1" readonly>
                        <button type="button" class="btn btn-secondary btn-sm increaseQty">+</button>
                    </td>
                    <td class="totalPrice">${selectedProductPrice}</td>
                    <td><button type="button" class="btn btn-danger removeProduct">Remove</button></td>
                </tr>
            `;
            $('#orderTableBody').append(row);
        }

        updateTotalPrice();
        selectedDropdown.val('');
    });

    // Remove or decrease product quantity
    $(document).on('click', '.removeProduct', function () {
        const row = $(this).closest('tr');
        const quantityInput = row.find('.quantity');
        const quantity = parseInt(quantityInput.val(), 10);

        if (quantity > 1) {
           
            
            // Decrease the quantity by 1 if greater than 1
            quantityInput.val(quantity - 1);
            row.find('.totalPrice').text((quantity - 1) * parseFloat(row.find('td:nth-child(3)').text()));
        } else {
            // If quantity is 1, remove the row entirely
            console.log("delete");
            row.remove();
        }

        updateTotalPrice();
    });

    // Increase product quantity
    $(document).on('click', '.increaseQty', function () {
        const row = $(this).closest('tr');
        const quantityInput = row.find('.quantity');
        const quantity = parseInt(quantityInput.val(), 10);
        const price = parseFloat(row.find('td:nth-child(3)').text());

        quantityInput.val(quantity + 1);
        row.find('.totalPrice').text((quantity + 1) * price);

        updateTotalPrice();
    });

    // Decrease product quantity
    $(document).on('click', '.decreaseQty', function () {
        const row = $(this).closest('tr');
        const quantityInput = row.find('.quantity');
        const quantity = parseInt(quantityInput.val(), 10);
        const price = parseFloat(row.find('td:nth-child(3)').text());

        if (quantity > 1) {
            quantityInput.val(quantity - 1);
            row.find('.totalPrice').text((quantity - 1) * price);
            updateTotalPrice();
        }
    });

    // Final order submit
    $('#submitOrder').click(function () {
        const customerId = $('#customer').val();
        const orderItems = [];
        $('#orderTableBody tr').each(function () {
            const productId = $(this).data('product-id');
            const quantity = parseInt($(this).find('.quantity').val());
            const price = parseFloat($(this).find('td:nth-child(3)').text());
            const totalPrice = parseFloat($(this).find('.totalPrice').text());
            const image = $(this).find('img').attr('src');

            orderItems.push({
                productId: productId,
                quantity: quantity,
                price: price,
                totalPrice: totalPrice,
                image: image
            });
        });

        if (orderItems.length === 0) {
            showMessage('Please add items to the order before submitting.', 'danger');
            return;
        }

        $.ajax({
            url: 'submit_order.php',  
            method: 'POST',
            data: {
                customerId: customerId,
                orderItems: orderItems
            },
            dataType: "JSON",
            success: function (response) {
                if (response.status == 'success') {
                    showMessage('Order submitted successfully!', 'success');
                    setTimeout(function () {
                        window.location.href = 'allorder.php';
                    }, 2000);
                } else {
                    showMessage('Failed to submit order. Please try again.', 'danger');
                }
            }
        });
    });

});
