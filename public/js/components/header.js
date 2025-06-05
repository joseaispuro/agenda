const template = `
<div id="header" class="header position-relative">
    <div class="container-fluid bg-primary text-white py-2 d-flex justify-content-between align-items-center">
        <div>
            <a href="https://mazatlan.gob.mx/">
            <img class="logo" :src="asset('img/shared/logo-mujer-white.png')"></a>
        </div>

        <!-- DESKTOP -->
        <div class="d-none d-md-block mx-3">

            <!-- Menú Dinámico -->
            <div v-for="(subheader, i) of menu" :key="i" class="sub-header-group">
                <span class="btn-header btn btn-sm px-4 me-2">
                    {{ subheader.label }}
                </span>

                <div class="sub-header">
                    <div class="sub-header-content d-flex text-white">
                        <div class="col-3 col-xl-4 col-xxl-5 collapse-title text-end rounded-end py-2 px-3">
                            {{ subheader.label }}
                        </div>

                        <div class="flex-fill header-links px-3">
                            <div v-for="(item, j) of subheader.items" :key="j" class="d-flex align-items-center" :class="{'custom-dropdown': item.items}">
                                <a class="header-link mx-2 mx-md-3 mx-lg-4 px-2" :href="item.link">{{ item.label }}</a>

                                <ul v-if="item.items" class="dropdown-menu dropdown-end py-3">
                                    <li v-for="(subitem, k) of item.items" :key="k">
                                        <a class="dropdown-item header-link" :href="subitem.link">{{ subitem.label }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MENU HAMBURGUESA -->
        <div class="d-block d-md-none">
            <button type="button" class="btn btn-header" style="width: unset" data-bs-toggle="offcanvas" data-bs-target="#header-offcanvas">
                <i class="fa-solid fa-lg fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- MOVIL -->
    <div class="d-block d-md-none">
        <div id="header-offcanvas" class="offcanvas offcanvas-end" tabindex="-1">
            <div class="offcanvas-body d-flex flex-column justify-content-between">
                <div>
                    <div class="text-end">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <!-- Menú Dinámico -->
                    <div v-for="(subheader, i) of menu" :key="i" class="mt-3">
                        <div class="list-group-title">{{ subheader.label }}</div>

                        <ul class="list-group">
                            <li v-for="(item, j) of subheader.items" :key="j" class="list-group-item">
                                <a class="header-link collapsed" :href="item.link ?? null" :data-bs-toggle="item.items ? 'collapse' : null" :data-bs-target="item.items ? '#sublist-' + i + '-' + j : null">
                                    <template v-if="item.items">
                                        <span class="symbol-open me-1"><i class="fa-solid fa-fw fa-plus"></i></span>
                                        <span class="symbol-close me-1"><i class="fa-solid fa-fw fa-minus"></i></span>
                                    </template>
                                    <span>{{ item.label }}</span>
                                </a>

                                <ul v-if="item.items" class="list-group sub-list collapse ms-3" :id="'sublist-' + i + '-' + j" data-bs-parent="#header-offcanvas">
                                    <li v-for="(subitem, k) of item.items" :key="k" class="list-group-item">
                                        <a class="header-link sub-link" :href="subitem.link">{{ subitem.label }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="d-flex mt-2">
                    <img class="offcanvas-logo m-auto mb-4" :src="asset('img/shared/logo-mujer-color.png')">
                </div>
            </div>
        </div>
    </div>
</div>
`;

export default {
    template,
    setup() {

        /** Configuración del Menú */
        const menu = [{
            label: "Gobierno",
            items: [
                { label: "Presidenta Municipal", link: "http://64.23.223.88/presidenta/" },
                { label: "Funcionarios", link: "http://64.23.223.88/funcionarios/" },
                { label: "Directorio", link: "http://64.23.223.88/directorio/" },
                { label: "Organigrama", link: "http://64.23.223.88/organigrama/" },
            ]
        }, {
            label: "Pagos en línea",
            items: [
                { label: "ISAI", link: "https://tics.mazatlan.gob.mx/servicios/isaienlinea/login" },
                { label: "Servicio de Limpia", link: "https://tics.mazatlan.gob.mx/servicios-limpia/" },
                { label: "Predial", link: "https://servicios.mazatlan.gob.mx/predial/" },
                { label: "Multas", link: "https://tics.mazatlan.gob.mx/servicios/transito/" },
            ]
        }, {
            label: "Trámites",
            items: [{
                label: "Tesorería",
                items: [
                    { label: "Impuesto sobre adquisicion de inmuebles ISAI", link: "https://tics.mazatlan.gob.mx/servicios/isaienlinea/login" },
                    { label: "Descuento de multas y recargos Predial", link: "https://servicios.mazatlan.gob.mx/predial/" },
                ]
            }, {
                label: "Desarrollo Urbano",
                items: [
                    { label: "Dictamen de Alineamiento", link: "https://tics.mazatlan.gob.mx/planeacion/login" },
                    { label: "Número Oficial", link: "https://tics.mazatlan.gob.mx/planeacion/login" },
                    { label: "Licencia de Construcción Fracc.", link: "https://tics.mazatlan.gob.mx/planeacion/login" },
                    { label: "Licencia de Construcción", link: "https://tics.mazatlan.gob.mx/planeacion/login" },
                    { label: "Dictamen de Uso de Suelo", link: "https://tics.mazatlan.gob.mx/planeacion/login" },
                ]
            }]
        }];

        /** Funcion de url para los assets */
        function asset(path) {
            const baseUrl = document.getElementsByTagName("meta").namedItem("base-url")?.content ?? '';
            return baseUrl.replace(/\/$/, '') + '/' + path.replace(/^\//, '');
        }

        return { menu, asset };
    }
};