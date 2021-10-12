import Vue from 'vue'
import Vuex from 'vuex'

import CompaniesIndex from './modules/Companies'
import CompaniesSingle from './modules/Companies/single'

import RolesIndex from './modules/Roles'
import RolesSingle from './modules/Roles/single'

import PermissionsIndex from './modules/Permissions'
import PermissionsSingle from './modules/Permissions/single'

import TitlesIndex from './modules/Titles'
import TitlesSingle from './modules/Titles/single'

import UsersIndex from './modules/Users'
import UsersSingle from './modules/Users/single'

import ProjectsIndex from './modules/Projects'
import ProjectsSingle from './modules/Projects/single'

import TimecardsIndex from './modules/Timecards/index'

import Alert from './modules/alert'
import ChangePassword from './modules/change_password'
import Auth from './modules/Auth/Auth'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        Alert,
        ChangePassword,
        CompaniesIndex,
        CompaniesSingle,
        RolesIndex,
        RolesSingle,
        PermissionsIndex,
        PermissionsSingle,
        TitlesIndex,
        TitlesSingle,
        UsersIndex,
        UsersSingle,
        ProjectsIndex,
        ProjectsSingle,
        Auth,
        TimecardsIndex
    },
    strict: debug,
})
