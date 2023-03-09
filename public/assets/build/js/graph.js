function getRandomColor(nb) {
    var colors = [];
    for (var i = 0; i < nb; i++) {
        var color = '#' + (0x1000000 + (Math.random()) * 0xffffff).toString(16).substr(1, 6);
        colors.push(color);
    }
    return colors;
}
function graph(mytype,idelement, nomlabels, titleelement, dataelement, nbelement) {
    var ctx = document.getElementById(idelement);
    var CelluleChart = new Chart(ctx, {
        type: mytype,
        data: {
            labels: nomlabels,
            datasets: [{
                label: titleelement,
                data: dataelement,
                backgroundColor: getRandomColor(nbelement),
                datalabels: {
                    color: 'black'
                }
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
}
