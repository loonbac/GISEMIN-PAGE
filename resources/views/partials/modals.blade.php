<!-- Global Custom Modals -->
<div id="custom-modal-container" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); align-items: center; justify-content: center;">
    <div id="custom-modal-content" style="background-color: #ffffff; margin: auto; padding: 24px; border: 1px solid rgba(226, 232, 240, 0.8); width: 100%; max-width: 400px; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); transform: translateY(-20px); transition: all 0.3s ease;">
        <div id="custom-modal-icon" style="margin-bottom: 16px; display: flex; justify-content: center;">
            <!-- Icon will be injected here -->
        </div>
        <h2 id="custom-modal-title" style="color: #1e293b; font-size: 18px; font-weight: 800; text-align: center; margin-bottom: 8px; font-family: 'Inter', sans-serif;"></h2>
        <p id="custom-modal-message" style="color: #64748b; font-size: 14px; text-align: center; margin-bottom: 24px; line-height: 1.5; font-family: 'Inter', sans-serif;"></p>
        
        <div id="custom-modal-footer" style="display: flex; gap: 12px; justify-content: center;">
            <button id="custom-modal-cancel" style="display: none; flex: 1; padding: 12px; border-radius: 12px; border: 2px solid #e2e8f0; background: #f8fafc; color: #64748b; font-weight: 700; cursor: pointer; font-size: 13px; transition: all 0.2s;">Cancelar</button>
            <button id="custom-modal-confirm" style="flex: 1; padding: 12px; border-radius: 12px; border: none; background: #0f5f8c; color: white; font-weight: 700; cursor: pointer; font-size: 13px; transition: all 0.2s;">Aceptar</button>
        </div>
    </div>
</div>

<script>
    const modalContainer = document.getElementById('custom-modal-container');
    const modalContent = document.getElementById('custom-modal-content');
    const modalTitle = document.getElementById('custom-modal-title');
    const modalMessage = document.getElementById('custom-modal-message');
    const modalIcon = document.getElementById('custom-modal-icon');
    const btnConfirm = document.getElementById('custom-modal-confirm');
    const btnCancel = document.getElementById('custom-modal-cancel');

    let currentResolve = null;

    window.showAlert = function(title, message, type = 'info') {
        return new Promise(resolve => {
            setupModal(title, message, type, false);
            currentResolve = resolve;
        });
    };

    window.showConfirm = function(title, message, type = 'warning') {
        return new Promise(resolve => {
            setupModal(title, message, type, true);
            currentResolve = resolve;
        });
    };

    function setupModal(title, message, type, isConfirm) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        
        // Setup Icon based on type
        let iconHtml = '';
        let confirmBtnColor = '#0f5f8c';
        
        if (type === 'success') {
            iconHtml = '<div style="background: #ecfdf5; color: #10b981; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg></div>';
            confirmBtnColor = '#10b981';
        } else if (type === 'error' || type === 'danger') {
            iconHtml = '<div style="background: #fef2f2; color: #ef4444; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>';
            confirmBtnColor = '#ef4444';
        } else if (type === 'warning') {
            iconHtml = '<div style="background: #fffbeb; color: #f59e0b; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>';
            confirmBtnColor = '#f59e0b';
        } else {
            iconHtml = '<div style="background: #eff6ff; color: #3b82f6; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></div>';
            confirmBtnColor = '#3b82f6';
        }
        
        modalIcon.innerHTML = iconHtml;
        btnConfirm.style.background = confirmBtnColor;
        
        btnCancel.style.display = isConfirm ? 'block' : 'none';
        
        modalContainer.style.display = 'flex';
        setTimeout(() => {
            modalContent.style.transform = 'translateY(0)';
        }, 10);
    }

    function closeModal(result) {
        modalContent.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            modalContainer.style.display = 'none';
            if (currentResolve) {
                currentResolve(result);
                currentResolve = null;
            }
        }, 200);
    }

    btnConfirm.addEventListener('click', () => closeModal(true));
    btnCancel.addEventListener('click', () => closeModal(false));

    // Handle hover effects for buttons
    btnConfirm.addEventListener('mouseenter', () => btnConfirm.style.opacity = '0.9');
    btnConfirm.addEventListener('mouseleave', () => btnConfirm.style.opacity = '1');
    btnCancel.addEventListener('mouseenter', () => btnCancel.style.background = '#f1f5f9');
    btnCancel.addEventListener('mouseleave', () => btnCancel.style.background = '#f8fafc');
</script>
