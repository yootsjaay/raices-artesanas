
function data() {
  /**
   * Obtiene el tema inicial:
   * 1. Prioriza lo guardado en LocalStorage.
   * 2. Si no hay nada, usa la preferencia del sistema operativo.
   */
  function getThemeFromLocalStorage() {
    const savedTheme = window.localStorage.getItem('dark');
    if (savedTheme !== null) {
      return JSON.parse(savedTheme);
    }
    return !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  }

  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('dark', value);
  }

  return {
    dark: getThemeFromLocalStorage(),
    
    // Al iniciar, aplicamos la clase correcta al HTML
    init() {
        this.$watch('dark', (value) => {
            setThemeToLocalStorage(value);
            this.applyTheme();
        });
        this.applyTheme();
    },

    applyTheme() {
        if (this.dark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },

    toggleTheme() {
      this.dark = !this.dark;
    },

    // --- Menús y UI ---
    isSideMenuOpen: false,
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen;
    },
    closeSideMenu() {
      this.isSideMenuOpen = false;
    },

    isNotificationsMenuOpen: false,
    toggleNotificationsMenu() {
      this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen;
    },
    closeNotificationsMenu() {
      this.isNotificationsMenuOpen = false;
    },

    isProfileMenuOpen: false,
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen;
    },
    closeProfileMenu() {
      this.isProfileMenuOpen = false;
    },

    isPagesMenuOpen: false,
    togglePagesMenu() {
      this.isPagesMenuOpen = !this.isPagesMenuOpen;
    },

    // --- Modal con Focus Trap ---
    isModalOpen: false,
    trapCleanup: null,
    openModal() {
      this.isModalOpen = true;
      // Añadimos un pequeño delay o comprobación para asegurar que el DOM existe
      this.$nextTick(() => {
        this.trapCleanup = focusTrap(document.querySelector('#modal'));
      });
    },
    closeModal() {
      this.isModalOpen = false;
      if (this.trapCleanup) {
        this.trapCleanup();
        this.trapCleanup = null;
      }
    },
  };
}