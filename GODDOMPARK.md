# God's Dom Park NAS – Complete Project Breakdown  
*(Laravel + Filament PHP)*

---

## 1. System Overview

God's Dom Park is a modern web-based Network Attached Storage (NAS) system featuring hierarchical, role-based access, comprehensive file, user, and storage management, built using Laravel and Filament PHP.

---

## 2. User Roles & Hierarchy

- **Owner:** Full system control, manages all users and settings, unlimited storage
- **Admin:** Manages Staff and Users, handles quotas, monitoring, not Owner-level
- **Staff:** Manages assigned Users only, work folders, limited admin features
- **User:** Personal storage and file management, no admin rights

---

## 3. Role-Based Dashboards & Features

### 3.1 Owner Dashboard  
**Theme:** Purple/Crown  
**Access:** Full (system-wide)

**Features:**
- System storage overview (used/available, health)
- User management (all roles: add/edit/delete/assign/suspend/reactivate)
- Role management (create/edit/delete roles)
- Storage quota management (all users/roles)
- Storage visualization (overall and per-user/role)
- System logs (activity, audit, security)
- Notifications (system-wide alerts)
- All system settings (themes, policies, integrations)
- Help/Support Center (all docs, edit access)

---

### 3.2 Admin Dashboard  
**Theme:** Red/Shield  
**Access:** All except Owner functions

**Features:**
- Staff/User management (add/edit/suspend/delete, assign roles)
- Assign/edit quotas for Staff/Users
- User activity logs
- Storage visualization (by department/group)
- System health monitor (admin-relevant)    
- Requests panel (approve/reject Staff/User requests)
- Admin notifications
- Help/Support Center (admin-specific)

---

### 3.3 Staff Dashboard  
**Theme:** Blue/Users  
**Access:** Operational (assigned Users only)

**Features:**
- Assigned User management (create/edit/suspend)
- Assign basic quotas to Users
- Designated work folders (file management)
- User activity monitoring (assigned Users)
- Request escalation to Admins
- Storage usage visualized for Staff's workspace and managed Users
- Staff notifications
- Help/Support Center (staff docs)

---

### 3.4 User Dashboard  
**Theme:** Green/User  
**Access:** Personal (own files and storage)

**Features:**
- Personal storage (upload/download, organize, search)
- Storage usage visualization (progress bar, by file type)
- File management (rename, move, delete, search)
- Cloud sync status
- Request panel (request more space, help)
- User notifications (quota, uploads, etc.)
- Help/Support Center (user guide, FAQ)

---

## 4. File Management Module

- Drag & drop uploads (multi-file/folder)
- Download (individual/batch, file preview if possible)
- List/grid view modes
- File type recognition and auto-icons
- File/folder search
- Folder creation, renaming, moving, deleting
- File actions (rename, move, delete, share if role allows)
- Role-based access (files/folders scoped per user)
- (Optional) File versioning

---

## 5. User Management Module

- User CRUD (by permission level)
- Role assignment/editing
- Storage quota setting/editing
- User status (Active/Suspended/Inactive)
- User activity logs (login, file ops, etc.)
- Bulk operations (batch suspend/delete)

---

## 6. Storage Management Module

- Real-time quota tracking (with live updates)
- Storage breakdown by file type (charts)
- Color-coded storage indicators (warnings, alerts)
- Quota editing UI (Owner/Admin)
- (Optional) File retention policy (auto-cleanup)

---

## 7. Help & Documentation

- Comprehensive user guides (role-specific)
- Troubleshooting and error resolution
- FAQ (dynamic/searchable)
- Support request/escalation system

---

## 8. System & Settings Module

- General settings (name, logo, theme)
- User/Role policies (hierarchy, deactivation rules)
- Email/SMS integration (notifications, resets)
- Audit logs (critical actions)
- (Optional) Language & localization

---

## 9. Notification & Requests Module

- Requests (User→Staff→Admin): quota, help, support
- Approval workflows (requests escalate to higher roles)
- Notifications (storage, user events, system alerts)

---

## 10. Database Design (Major Tables)

| Table           | Key Fields                                                       |
|-----------------|------------------------------------------------------------------|
| users           | id, name, email, password, role_id, status, quota, avatar        |
| roles           | id, name, hierarchy_level, color, icon, permissions              |
| files           | id, name, path, owner_id, folder_id, size, type, version, ...    |
| folders         | id, name, parent_id, owner_id, role_scope                        |
| quotas          | id, user_id, assigned, used, updated_at                          |
| user_activity   | id, user_id, action, entity_id, entity_type, timestamp           |
| notifications   | id, user_id, type, message, read_at, related_id, ...             |
| settings        | id, key, value, type, editable                                   |
| help_articles   | id, title, content, role_scope, order                            |
| requests        | id, from_user_id, to_role, type, status, data, resolved_at        |

---

## 11. Filament PHP Panel & Resource Mapping

- **UserResource:** All user management (role-scoped)
- **RoleResource:** Role management (Owner/Admin)
- **FileResource:** File/folder CRUD, permissions
- **FolderResource:** Nested, tree UI in Filament
- **QuotaResource:** Quota management
- **StorageDashboard:** Custom widgets for stats
- **HelpResource:** Docs and FAQ (role-scoped)
- **RequestResource:** Approvals, escalations

**Filament Features:**
- Custom dashboards (per role, themed)
- Adaptive navigation (sidebar/topbar)
- Widgets: storage progress, activity feed, role/user stats, quick actions
- In-app notifications

---

## 12. UI/UX Details

- Responsive design (mobile/tablet/desktop)
- Role-specific themes (colors/icons/branding)
- Material icons & animations
- Error/loading states, accessibility

---

## 13. Error Handling & Security

- Backend and frontend validation
- File path/ownership enforcement
- Rate limiting (uploads/requests)
- Audit logs (critical events)
- (Optional) Backups

---

## 14. Mock Data (Seeding)

- Sample users (all roles)
- Files/folders (docs, images, videos)
- Help docs/FAQ/requests/notifications
- Quotas, settings

---

## 15. Suggested Laravel Project Structure

@php
    $stats = $this->getStats();
@endphp

