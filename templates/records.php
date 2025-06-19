<div class="container mt-4">
  <h2 class="text-center mb-4">Student Prerequisite Records</h2>

  <!-- Dynamic Dropdown Filters -->
  <div class="row mb-4 justify-content-center g-2">
    <div class="col-md-3 col-sm-6">
      <select class="form-select form-select-sm" id="filterType">
        <option selected disabled>Filter Type</option>
        <option value="program">Program & Year</option>
        <option value="course">Course</option>
      </select>
    </div>
    <div class="col-md-3 col-sm-6">
      <select class="form-select form-select-sm" id="filterValue" disabled>
        <option selected disabled>Select Value</option>
      </select>
    </div>
  </div>

  <!-- Prompt -->
  <div id="promptMessage" class="alert text-center" style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7;">
    Please filter by program or course first.
  </div>

  <!-- Table Section -->
  <div id="attendanceSection" class="table-responsive" style="display: none;">
    <table class="table table-bordered table-hover bg-white" id="recordsTable">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Student Name</th>
          <th>Program</th>
          <th>Year Level</th>
          <th>Course</th>
          <th>Prerequisite</th>
          <th>Prerequisite Grade</th>
          <th>Semester</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Acina, Laurice</td>
          <td>DIT</td>
          <td>2</td>
          <td>Object Oriented Programming</td>
          <td>Programming 2</td>
          <td>89</td>
          <td>1st Sem, 2023</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Gomez, Carlo</td>
          <td>BSIT</td>
          <td>3</td>
          <td>Advanced Programming</td>
          <td>OOP</td>
          <td>74</td>
          <td>2nd Sem, 2023</td>
        </tr>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>
</div>

<!-- Styles -->
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

<!-- Script for dynamic dropdown and filtering -->
<script>
  const filterType = document.getElementById('filterType');
  const filterValue = document.getElementById('filterValue');
  const promptMessage = document.getElementById('promptMessage');
  const attendanceSection = document.getElementById('attendanceSection');
  const tableRows = document.querySelectorAll('#recordsTable tbody tr');

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
    const selectedType = filterType.value;
    const selectedValue = this.value;
    let matchCount = 0;

    tableRows.forEach(row => {
      const program = row.cells[2].textContent.trim();
      const year = row.cells[3].textContent.trim();
      const course = row.cells[4].textContent.trim();

      let match = false;

      if (selectedType === 'program') {
        const [selectedProgram, selectedYear] = selectedValue.split(' ');
        match = program === selectedProgram && year === selectedYear;
      } else if (selectedType === 'course') {
        match = course === selectedValue;
      }

      row.style.display = match ? '' : 'none';
      if (match) matchCount++;
    });

    promptMessage.style.display = 'none';
    attendanceSection.style.display = matchCount > 0 ? 'block' : 'none';
  });
</script>