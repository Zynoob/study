export default [{
        path: '/teacher',
        name: 'teacher',
        component: () => import("../views/teacher/Index.vue"),
        children: [{
                path: 'buildpaper',
                name: 'teacher_buildpaper',
                component: () => import('../views/teacher/Paper.vue')
            },
            {
                path: 'paperinfo',
                name: 'teacher_paperinfo',
                component: () => import('../views/teacher/PaperInfo.vue')
            },
            {
                path: 'single',
                name: 'teacher_single',
                component: () => import('../views/teacher/SingleQuestion.vue')
            },
            {
                path: 'search',
                name: 'teacher_searchteacher',
                component: () => import('../views/teacher/SearchOfTeahcer.vue')
            },
            {
                path: 'mypaper',
                name: 'teacher_mypaper',
                component: () => import('../views/teacher/MyPaper.vue')
            }
        ]
    },
    {
        path: '/teacher/personinfo',
        name: 'teacher_personinfo',
        component: () => import('../views/teacher/PersonInfo.vue'),
        children:[
            {
                path: 'baseinfo',
                name: 'teacher_baseinfo',
                component: () => import('../views/teacher/BaseInfo.vue')
            },
            {
                path: 'modifypwd',
                name: 'teacher_modifypwd',
                component: () => import('../views/teacher/ModifyPassword.vue')
            },
        ]
    }
]