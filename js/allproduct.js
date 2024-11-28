function loadProducts(page = 1) {
    $.ajax({
      url: "get_product.php",  
      type: "GET",
      data: { page: page },
      dataType: "json",
      success: function (response) {
        const { data, totalPages, currentPage } = response;

        
        let tableRows = "";
        if (data.length > 0) {
          data.forEach((item, index) => {
            let productImages = '';
            if (item.images) {
              const images = item.images.split(',');  
              productImages = images.map(image => `<img src="${image}" alt="Product Image" width="50" height="50">`).join(' ');
            }

            tableRows += `
          <tr>
            <td>${(currentPage - 1) * 5 + (index + 1)}</td>
            <td>${item.pname}</td>
            <td>${item.cname}</td>
            <td>${item.pdes}</td>
            <td>${item.price}</td>
            <td>${item.stock}</td>
            <td>${productImages}</td>  <!-- Display images -->
            <td>
              <button class='btn btn-success'><a href='editproduct.php?pid=${item.pid}' class='text-white'>Edit</a></button>
              <button class='btn btn-danger delete-btn' data-id='${item.pid}'>Delete</button>
            </td>
          </tr>`;
          });
        } else {
          tableRows = "<tr><td colspan='7'>No products found</td></tr>"; 
        }
        $("#productTable").html(tableRows);

        let paginationLinks = "";

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
        for (let i = 1; i <= totalPages; i++) {
          paginationLinks += `
        <li class="page-item ${i === currentPage ? 'active' : ''}">
          <a class="page-link" href="#" data-page="${i}">${i}</a>
        </li>`;
        }

        // Next Button
        if (currentPage < totalPages) {
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

        $("#pagination").html(paginationLinks);
      },
      error: function () {
        alert("Failed to fetch data.");
      },
    });
  }

  loadProducts();

  $(document).on("click", ".page-link", function (e) {
    e.preventDefault();
    const page = $(this).data("page");
    if (page) {
      loadProducts(page); 
    }
  });

  // Handle delete button click
  $(document).on("click", ".delete-btn", function () {
    const pid = $(this).data("id");

    if (confirm("Are you sure you want to delete this product?")) {
      $.ajax({
        url: "delete_product.php", 
        type: "POST",
        data: { pid: pid },
        dataType: "json",
        success: function (response) {
          if (response.success) {
            loadProducts();
          } else {
            alert(response.message);
          }
        },
        error: function () {
          alert("An error occurred while trying to delete the product.");
        }
      });
    }
  });