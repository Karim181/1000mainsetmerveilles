            </main>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.admin-sidebar').classList.toggle('open');
        });

        // Close sidebar when clicking outside on mobile
        document.querySelector('.admin-main')?.addEventListener('click', function() {
            document.querySelector('.admin-sidebar').classList.remove('open');
        });
    </script>
</body>
</html>
