<div class="container">
  <h2 class="text-center mb-4">Student List</h2>

  <!-- Filter Dropdowns -->
  <div class="row mb-4">
    <div class="col-md-3 col-sm-5 mb-2 mb-sm-0">
      <select id="filterType" class="form-select small-dropdown">
        <option value="" selected disabled>Filter by</option>
        <option value="program">Program</option>
        <option value="course">Course</option>
      </select>
    </div>
    <div class="col-md-3 col-sm-5">
      <select id="filterValue" class="form-select small-dropdown" disabled>
        <option value="" selected disabled>Select Value</option>
      </select>
    </div>
  </div>

  <!-- Student Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
      <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Course</th>
          <th>Program</th>
          <th>Profile</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1. Acina, Laurice</td>
          <td>Programming 2</td>
          <td>BSIT 1</td>
          <td><a href="#" class="btn btn-sm btn-outline-primary">View Details</a></td>
        </tr>
        <tr>
          <td>2. Gomez, Carlo</td>
          <td>Object Oriented Programming</td>
          <td>DIT 2</td>
          <td><a href="#" class="btn btn-sm btn-outline-primary">View Details</a></td>
        </tr>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>
</div>

<!-- Styles to make dropdowns thinner -->
<style>
  .small-dropdown {
    padding: 8px 12px;
    font-size: 0.9rem;
  }

  @media (min-width: 576px) {
    .row.mb-4 > div {
      padding-left: 5px;
      padding-right: 5px;
    }
  }
</style>

<!-- Script for dynamic dropdown -->
<script>
  const filterType = document.getElementById('filterType');
  const filterValue = document.getElementById('filterValue');

  const options = {
    program: ['DIT 1', 'DIT 2', 'DIT 3', 'BSIT 1', 'BSIT 2', 'BSIT 3', 'BSIT 4'],
    course: ['Programming 2', 'Object Oriented Programming', 'Advanced Programming']
  };

  filterType.addEventListener('change', function () {
    const selected = this.value;
    const valueOptions = options[selected] || [];

    filterValue.innerHTML = '<option selected disabled>Select Value</option>';
    filterValue.disabled = false;

    valueOptions.forEach(item => {
      const option = document.createElement('option');
      option.value = item;
      option.textContent = item;
      filterValue.appendChild(option);
    });
  });
</script>