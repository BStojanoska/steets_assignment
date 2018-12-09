$(document).ready(function() {
  App.init();
});

// Previous Database Entries
const PreviousEntriesTable = {
  tableRows(data) {
    let tableBody = ``;
    let rows = 1;

    data.forEach(d => {
      tableBody += `
      <tr>
          <td> ${rows} </td>
          <td style="witdh: 33%;"> ${d.year} </td>
          <td style="witdh: 33%;"> ${d.day} </td>   
        </tr>
      `;
      rows++;
    });
    return tableBody;
  },
  dbTable(data) {
    const table = `
        <h4 class="text-muted text-center col-12 py-5">
          Your previous searches:
        </h4>

        <table class="table table-striped table-sm col-10 mx-auto">
            <thead>
              <tr>
                <th colspan="1">#</th>
                <th colspan="1">Year</th>
                <th colspan="2">Christmas</th>
              </tr>
            </thead>
            <tbody>
               ${PreviousEntriesTable.tableRows(data)}
            </tbody>
        </table>
      `;

    return $(".database-entries").append(table);
  },
  clearDbTable() {
    $(".database-entries")
      .children()
      .remove();
  },
  render(data) {
    PreviousEntriesTable.clearDbTable();
    PreviousEntriesTable.dbTable(data["dbEntries"]);
  }
};

// Prime years and Christmas Day
const YearsTable = {
  postChristmasDay(christmas, year) {
    const string = `<h3 class="text-muted text-center col-12 pb-5 christmas">Christmas in ${year} ${christmas}!</h3>`;

    return $(".calculation").append(string);
  },
  tableRows(years) {
    let tableBody = ``;
    let loop = 0;
    let rows = 1;

    years.forEach(year => {
      if (loop % 3 == 0) {
        tableBody += `
                </tr>
                <tr>
                <td> ${rows} </td>
            `;
        rows++;
      }
      tableBody += `<td style="witdh: 33%;"> ${year} </td>`;
      loop++;
    });
    return tableBody;
  },
  primeYearsTable(years) {
    const table = `
        <h5 class="text-muted text-center col-12 pb-5 hide">
          The previous 30 years from your chosen date that are prime numbers
          are:
        </h5>

        <table class="table table-striped table-sm col-12 mx-auto">
            <thead>
              <tr>
                <th colspan="1">#</th>
                <th colspan="3">Prime years</th>
              </tr>
            </thead>
            <tbody>
               ${YearsTable.tableRows(years)}
            </tbody>
        </table>
      `;

    return $(".calculation").append(table);
  },
  render(data) {
    YearsTable.postChristmasDay(data["christmas"], data["year"]);
    YearsTable.primeYearsTable(data["primeYears"]);
  }
};

// Form date input
const DateInput = {
  init() {
    $("form").on("submit", DateInput.onSubmit);
  },
  onError() {
    $("#date-error").show();
  },
  clearYearTable() {
    $(".calculation")
      .children()
      .remove();

    $("#date-error").hide();
    $("form")[0].reset();
  },
  onSubmit(e) {
    // Submit form
    e.preventDefault();

    $.ajax({
      url: "/src/app.php",
      method: "post",
      data: $("form").serialize()
    })
      .done(response => {
        let data = JSON.parse(response);
        DateInput.clearYearTable();

        if (data) {
          YearsTable.render(data);
          PreviousEntriesTable.render(data);
        } else {
          DateInput.onError();
        }
      })
      .fail(() => {
        alert("Something went wrong!");
      });
  }
};

const App = {
  init() {
    DateInput.clearYearTable();
    DateInput.init();
  }
};
