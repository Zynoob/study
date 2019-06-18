export default [{
    path: "/admin",
    name: 'admin',
    component: () => import("../views/admin/Index.vue"),
    children: [{
            path: 'buildpaper',
            name: 'admin_buildpaper',
            component: () => import('../views/admin/Paper.vue')
        },
        {
            path: 'paperinfo',
            name: 'admin_paperinfo',
            component: () => import('../views/admin/PaperInfo.vue')
        },
        {
            path: 'single',
            name: 'admin_single',
            component: () => import('../views/admin/SingleQuestion.vue')
        },
        {
            path: 'creatteacher',
            name: 'admin_creatteacher',
            component: () => import('../views/admin/CreatTeacher.vue')
        },
        {
            path: 'mypaper',
            name: 'admin_mypaper',
            component: () => import('../views/admin/MyPaper.vue')
        },
        {
            path: 'onestudent',
            name: 'admin_onestudent',
            component: () => import('../views/Null.vue')
        },
        {
            path: 'oneteacher',
            name: 'admin_oneteacher',
            component: () => import('../views/Null.vue')
        },
        {
            path: 'lookonepaper',
            name: 'admin_lookonepaper',
            component: () => import('../views/admin/LookOnePaper.vue')
        }
    ]
}, {
    path: '/admin/personinfo',
    name: 'admin_personinfo',
    component: () => import('../views/admin/PersonInfo.vue'),
    children: [{
            path: 'baseinfo',
            name: 'admin_baseinfo',
            component: () => import('../views/admin/BaseInfo.vue')
        },
        {
            path: 'modifypwd',
            name: 'admin_modifypwd',
            component: () => import('../views/admin/ModifyPassword.vue')
        },
    ]
}]