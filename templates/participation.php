<div class="container">
  <h2 class="text-center mb-4">Participation</h2>

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

  <!-- Prompt message -->
  <div id="promptMessage" class="alert text-center" style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7;">
    Please filter by program or course first.
  </div>

  <!-- Attendance Table -->
  <div id="attendanceSection" class="table-responsive" style="display: none;">
    <table class="table table-bordered table-hover bg-white">
      <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Course</th>
          <th>Program</th>
          <th>Score</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-start">Laurice Acina</td>
          <td>Programming 2</td>
          <td>BSIT 1</td>
          <td>5</td>
        </tr>
        <tr>
          <td class="text-start">John Doe</td>
          <td>Object Oriented Programming</td>
          <td>DIT 2</td>
          <td>3</td>
        </tr>
        <tr>
          <td class="text-start">Jane Smith</td>
          <td>Advanced Programming</td>
          <td>BSIT 3</td>
          <td>2</td>
        </tr>
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

<!-- Script for dynamic dropdown and table reveal -->
<script>
  const filterType = document.getElementById('filterType');
  const filterValue = document.getElementById('filterValue');
  const promptMessage = document.getElementById('promptMessage');
  const attendanceSection = document.getElementById('attendanceSection');

  const options = {
    program: ['DIT 1', 'DIT 2', 'DIT 3', 'BSIT 1', 'BSIT 2', 'BSIT 3', 'BSIT 4'],
    course: ['Programming 2', 'Object Oriented Programming', 'Advanced Programming']
  };

  filterType.addEventListener('change', function () {
    const selected = this.value;
    const valueOptions = options[selected] || [];

    filterValue.innerHTML = '<option selected disabled>Select Value</option>';
    filterValue.disabled = false;
    promptMessage.style.display = 'block';
    attendanceSection.style.display = 'none';

    valueOptions.forEach(item => {
      const option = document.createElement('option');
      option.value = item;
      option.textContent = item;
      filterValue.appendChild(option);
    });
  });

  filterValue.addEventListener('change', function () {
    if (this.value !== '') {
      promptMessage.style.display = 'none';
      attendanceSection.style.display = 'block';
    }
  });
</script>
