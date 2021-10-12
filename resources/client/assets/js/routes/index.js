import Vue from 'vue'
import VueRouter from 'vue-router'

import ChangePassword from '../components/ChangePassword.vue'

import CompaniesIndex from '../components/cruds/Companies/Index.vue'
import CompaniesCreate from '../components/cruds/Companies/Create.vue'
import CompaniesShow from '../components/cruds/Companies/Show.vue'
import CompaniesEdit from '../components/cruds/Companies/Edit.vue'

import RolesIndex from '../components/cruds/Roles/Index.vue'
import RolesCreate from '../components/cruds/Roles/Create.vue'
import RolesShow from '../components/cruds/Roles/Show.vue'
import RolesEdit from '../components/cruds/Roles/Edit.vue'

import PermissionsIndex from '../components/cruds/Permissions/Index.vue'
import PermissionsCreate from '../components/cruds/Permissions/Create.vue'
import PermissionsShow from '../components/cruds/Permissions/Show.vue'
import PermissionsEdit from '../components/cruds/Permissions/Edit.vue'

import TitlesIndex from '../components/cruds/Titles/Index.vue'
import TitlesCreate from '../components/cruds/Titles/Create.vue'
import TitlesShow from '../components/cruds/Titles/Show.vue'
import TitlesEdit from '../components/cruds/Titles/Edit.vue'

import UsersIndex from '../components/cruds/Users/Index.vue'
import UsersShow from '../components/cruds/Users/Show.vue'
import UsersEdit from '../components/cruds/Users/Edit.vue'

import ProjectsIndex from '../components/cruds/Projects/Index.vue'
import ProjectsShow from '../components/cruds/Projects/Show.vue'
import ProjectsEdit from '../components/cruds/Projects/Edit.vue'

import DashboardIndex from '../components/Dashboard/DashboardPage.vue'
import DashboardCardShow from '../components/Dashboard/DashboardCardShow.vue'

import PhotoPage from '../components/Photo/PhotoPage.vue'
import TimecardPage from '../components/Timecard/TimecardPage.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/change-password', component: ChangePassword, name: 'auth.change_password' },

    { path: '/companies', component: CompaniesIndex, name: 'companies.index' },
    { path: '/companies/create', component: CompaniesCreate, name: 'companies.create' },
    { path: '/companies/:id', component: CompaniesShow, name: 'companies.show' },
    { path: '/companies/:id/edit', component: CompaniesEdit, name: 'companies.edit' },

    { path: '/roles', component: RolesIndex, name: 'roles.index' },
    { path: '/roles/create', component: RolesCreate, name: 'roles.create' },
    { path: '/roles/:id', component: RolesShow, name: 'roles.show' },
    { path: '/roles/:id/edit', component: RolesEdit, name: 'roles.edit' },

    { path: '/permissions', component: PermissionsIndex, name: 'permissions.index' },
    { path: '/permissions/create', component: PermissionsCreate, name: 'permissions.create' },
    { path: '/permissions/:id', component: PermissionsShow, name: 'permissions.show' },
    { path: '/permissions/:id/edit', component: PermissionsEdit, name: 'permissions.edit' },

    { path: '/titles', component: TitlesIndex, name: 'titles.index' },
    { path: '/titles/create', component: TitlesCreate, name: 'titles.create' },
    { path: '/titles/:id', component: TitlesShow, name: 'titles.show' },
    { path: '/titles/:id/edit', component: TitlesEdit, name: 'titles.edit' },
    
    { path: '/users', component: UsersIndex, name: 'users.index' },
    { path: '/users/create', component: UsersEdit, name: 'users.create' },
    { path: '/users/:id', component: UsersShow, name: 'users.show' },
    { path: '/users/:id/edit', component: UsersEdit, name: 'users.edit' },

    { path: '/projects', component: ProjectsIndex, name: 'projects.index' },
    { path: '/projects/create', component: ProjectsEdit, name: 'projects.create' },
    { path: '/projects/:id', component: ProjectsShow, name: 'projects.show' },
    { path: '/projects/:id/edit', component: ProjectsEdit, name: 'projects.edit' },

    { path: '/dashboard', component: DashboardIndex, name: 'dashboard.index' },
    { path: '/dashboard/:id', component: DashboardCardShow, name: 'dashboard.show' },

    { path: '/project-assign/photo', component: PhotoPage, name: 'project.photo.index' },
    { path: '/project-assign/timecard', component: TimecardPage, name: 'project.timecard.index' },
]

export default new VueRouter({
    mode: 'history',
    base: '/admin',
    routes
})
