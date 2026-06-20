        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Toggle submenu (accordion ringan, lebih dari satu boleh terbuka)
document.querySelectorAll('[data-toggle-submenu]').forEach(function(link){
    link.addEventListener('click', function(){
        this.closest('.nav-group').classList.toggle('open');
    });
});

// Toggle sidebar di layar kecil
var toggleBtn = document.getElementById('toggleSidebar');
var sidebar   = document.getElementById('sidebar');
if(toggleBtn){
    toggleBtn.addEventListener('click', function(){
        sidebar.classList.toggle('show');
    });
    document.addEventListener('click', function(e){
        if(window.innerWidth <= 991 &&
           sidebar.classList.contains('show') &&
           !sidebar.contains(e.target) &&
           e.target !== toggleBtn && !toggleBtn.contains(e.target)){
            sidebar.classList.remove('show');
        }
    });
}

// Filter pencarian sisi-klien untuk tabel manapun yang punya [data-search-table]
document.querySelectorAll('[data-search-input]').forEach(function(input){
    input.addEventListener('keyup', function(){
        var keyword = this.value.toLowerCase();
        var tableId = this.getAttribute('data-search-input');
        var table = document.getElementById(tableId);
        if(!table) return;
        var rows = table.querySelectorAll('tbody tr[data-row]');
        var visible = 0;
        rows.forEach(function(row){
            var match = row.innerText.toLowerCase().indexOf(keyword) > -1;
            row.style.display = match ? '' : 'none';
            if(match) visible++;
        });
        var emptyRow = table.querySelector('.js-empty-search');
        if(emptyRow){
            emptyRow.style.display = visible === 0 ? '' : 'none';
        }
    });
});
</script>
</body>
</html>
