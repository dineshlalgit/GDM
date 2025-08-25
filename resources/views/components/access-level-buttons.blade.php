<div class="access-level-grid">
    <div class="access-btn owner" onclick="selectAccessBtn(this)">
        <span class="icon">👑</span>
        <span>Owner</span>
    </div>
    <div class="access-btn admin" onclick="selectAccessBtn(this)">
        <span class="icon">🛡️</span>
        <span>Admin</span>
    </div>
    <div class="access-btn staff" onclick="selectAccessBtn(this)">
        <span class="icon">👥</span>
        <span>Staff</span>
    </div>
    <div class="access-btn user" onclick="selectAccessBtn(this)">
        <span class="icon">👤</span>
        <span>User</span>
    </div>
</div>

<script>
function selectAccessBtn(el) {
    document.querySelectorAll('.access-btn').forEach(btn => btn.classList.remove('selected'));
    el.classList.add('selected');
}
</script>

<style>
.access-level-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}
.access-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem 0;
    font-size: 1.1rem;
    font-weight: 500;
    cursor: pointer;
    transition: border-color 0.2s, color 0.2s;
    background: #fff;
}
.access-btn .icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}
.access-btn.owner:hover, .access-btn.owner.selected {
    border-color: #8b5cf6;
    color: #8b5cf6;
}
.access-btn.admin:hover, .access-btn.admin.selected {
    border-color: #f59e42;
    color: #f59e42;
}
.access-btn.staff:hover, .access-btn.staff.selected {
    border-color: #3b82f6;
    color: #3b82f6;
}
.access-btn.user:hover, .access-btn.user.selected {
    border-color: #10b981;
    color: #10b981;
}
</style>
