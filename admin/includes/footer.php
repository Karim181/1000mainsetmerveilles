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

        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = document.getElementById(this.dataset.target);
                var isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                this.querySelector('.eye-open').style.display = isPassword ? 'none' : 'block';
                this.querySelector('.eye-closed').style.display = isPassword ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
