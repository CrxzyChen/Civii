(function () {
    function Civii() {
        this.root_path = this.getRootPath_web();
        this.cid = this.getCid();
        this.link(this.cid);
    }

    Civii.prototype = {
        constructor: Civii, getRootPath_web: function () {
            //获取当前网址，如： http://localhost:8083/uimcardprj/share/meun.jsp
            let curWwwPath = window.document.location.href;
            //获取主机地址之后的目录，如： uimcardprj/share/meun.jsp
            let pathName = window.document.location.pathname;
            let pos = curWwwPath.indexOf(pathName);
            //获取主机地址，如： http://localhost:8083
            let localhostPaht = curWwwPath.substring(0, pos);
            //获取带"/"的项目名，如：/uimcardprj
            let projectName = pathName.substring(0, pathName.substr(1).indexOf('/') + 1);
            return (localhostPaht + projectName);
        }, getCid: function () {
            if ((match_result = /player\/(\w+)/.exec(window.document.location.pathname))) {
                cid = match_result[1];
            } else {
                window.document.location.href = root_path + "/view/index/"
            }
            return cid;
        }, renderPlayer: function () {
            this.player = new BiliH5Player();
            this.player.create({
                get_from_local: !0,
                comment: "2",
                image: this.data['current_video']['cover_url'],
                video_url: this.data['current_video']['video_url']
            });
        }, link: function (cid, callback) {
            $.get(this.root_path + '/api/get/' + cid, this.mounted, 'json');
        }, mounted: function (response) {
            console.log(response);
            civii.data = response;
            civii.renderPlayer();
            civii.loadBrief();
            civii.loadPartList()

        }, loadPartList: function () {
            this.part_list = new Vue({
                el: '.part-list',
                data: {
                    count: 4,
                    current_part: this.data['current_video']['part_num'],
                    list: this.data['group_member']
                }, methods: {
                    changePart: function (event) {
                        console.log(event);
                        $('#bofqi').html('');
                        this.current_part = (event + 1) + "";
                        new BiliH5Player().create({
                            get_from_local: !0,
                            comment: "2",
                            image: civii.data['group_member'][event]['cover_url'],
                            video_url: civii.data['group_member'][event]['video_url']
                        });
                    }
                }, mounted: function () {
                    let offsetLeft = $('.cur').position().left;
                    let maxOffset = -($('.slider-content').width() - $('.slider-wrapper').width());
                    console.log(maxOffset);
                    let myScroll = new IScroll('.slider-wrapper', {
                        scrollY: false,
                        scrollX: true,
                        fadeScrollbars: true,
                        scrollbars: true,
                        click:true,
                        startX: Math.max(Math.min(-offsetLeft + 150, 0), maxOffset)
                    });
                }, updated: function () {
                    $('.control-bar').addClass('hide');
                }
            });
        }, loadBrief: function () {
            this.brief = new Vue({
                el: '.brief',
                data: this.data['group']
            })
        }
    };
    let civii = new Civii();
})();







