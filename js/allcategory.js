function loadCategories(page = 1) {
    $.ajax({
      url: "get_categories.php",
      type: "GET",
      data: { page: page },
      dataType: "json",
      success: function (response) {
        const { data, totalPages, currentPage } = response;

        // Populate table
        let tableRows = "";
        if (data.length > 0) {
          data.forEach((item, index) => {
            tableRows += `
        <tr>
          <td>${(currentPage - 1) * 5 + (index + 1)}</td>
          <td>${item.cname}</td>
          <td>${item.cdes}</td>
          <td>
            <button class='btn btn-success'><a href='editcategory.php?cid=${item.cid}' class='text-white'>Edit</a></button>
            <button class='btn btn-danger delete-btn' data-id='${item.cid}'>Delete</button>
          </td>
        </tr>`;
          });
        } else {
          tableRows = "<tr><td colspan='4'>No categories found</td></tr>";
        }
        $("#categoryTable").html(tableRows);

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

  loadCategories();

  $(document).on("click", ".page-link", function (e) {
    e.preventDefault();
    const page = $(this).data("page");
    if (page) {
      loadCategories(page);
    }
  });

  $(document).on("click", ".delete-btn", function () {
    const cid = $(this).data("id");

    if (confirm("Are you sure you want to delete this category?")) {
      $.ajax({
        url: "delete_category.php",
        type: "POST",
        data: { cid: cid },
        dataType: "json",
        success: function (response) {
          if (response.success) {
            location.reload();
          } else {
            alert(response.message);
          }
        },
        error: function () {
          alert("An error occurred while trying to delete the category.");
        }
      });
    }
  });