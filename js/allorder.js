$(document).ready(function () {
  let currentPage = 1;
  function loadOrders(page = 1) {
      $.ajax({
          url: 'fetch_orders.php',
          type: 'GET',
          dataType: 'json',
          data: { page: page }, 
          success: function (data) {
            console.log(data); // Add this line to inspect the returned data
            $('#orderTableBody').empty();
            if (data.orders.length > 0) {
                data.orders.forEach(order => {
                    const row = `
                        <tr>
                            <td>${order.customer_name}</td>
                            <td>${order.product_count}</td>
                            <td>$${order.total_price}</td>
                            <td>${order.order_date}</td>
                            <td>
                                <a href="order_details.php?order_id=${order.order_id}" class="btn btn-primary btn-sm" title="View Details">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </td>
                        </tr>`;
                    $('#orderTableBody').append(row);
                });
            } else {
                $('#orderTableBody').append('<tr><td colspan="5" class="text-center">No orders found</td></tr>');
            }
            // $("#orderTableBody").html(row);

            // Populate pagination
            let paginationLinks = "";
        
            // Previous Button
            if (currentPage > 1) {
                paginationLinks += `
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="${currentPage - 1}">
                            <i class="fas fa-angle-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>`;
            } else {
                paginationLinks += `
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">
                            <i class="fas fa-angle-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>`;
            }
        
            // Page Links
            for (let i = 1; i <= data.total_pages; i++) {
                paginationLinks += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>`;
            }
        
            // Next Button
            if (currentPage < data.total_pages) {
                paginationLinks += `
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="${currentPage + 1}">
                            <i class="fas fa-angle-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>`;
            } else {
                paginationLinks += `
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">
                            <i class="fas fa-angle-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>`;
            }
        
            // Update pagination
            $("#pagination").html(paginationLinks);
        },
        
          error: function (xhr, status, error) {
              console.error('Error fetching orders:', error);
              console.log('Response Text:', xhr.responseText);
          }
      });
  }

  // Initial load of orders
  loadOrders(currentPage);

  // Handle page click
  $(document).on("click", ".page-link", function (e) {
      e.preventDefault();
      const page = $(this).data("page");
      if (page) {
          currentPage = page;
          loadOrders(currentPage); // Load orders for the selected page
      }
  });
});
