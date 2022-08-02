/*
 *  Document   : custom_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Plugin Init Example Page
 */

// DataTables, for more examples you can check out https://www.datatables.net/
class TablesDatatables {
    /*
     * Init DataTables functionality
     *
     */
    static initDataTables() {
        // Override a few default classes
        jQuery.extend(jQuery.fn.dataTable.ext.classes, {
            sWrapper: "dataTables_wrapper dt-bootstrap5",
            sFilterInput: "form-control form-control-sm",
            sLengthSelect: "form-select form-select-sm",
        });

        // Override a few defaults
        jQuery.extend(true, jQuery.fn.dataTable.defaults, {
            language: {
                decima: ".",
                processing: "Đang xử lý...",
                infoFiltered: "(được lọc từ _MAX_ mục)",
                aria: {
                    sortAscending: ": Sắp xếp thứ tự tăng dần",
                    sortDescending: ": Sắp xếp thứ tự giảm dần",
                },
                autoFill: {
                    cancel: "Hủy",
                    fill: "Điền tất cả ô với <i>%d</i>",
                    fillHorizontal: "Điền theo hàng ngang",
                    fillVertical: "Điền theo hàng dọc",
                },
                buttons: {
                    collection:
                        'Chọn lọc <span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-s"></span>',
                    colvis: "Hiển thị theo cột",
                    colvisRestore: "Khôi phục hiển thị",
                    copy: "Sao chép",
                    copyKeys:
                        "Nhấn Ctrl hoặc u2318 + C để sao chép bảng dữ liệu.<br /><br />Để hủy, click vào thông báo này hoặc nhấn ESC",
                    copySuccess: {
                        1: "Đã sao chép 1 dòng dữ liệu vào bộ nhớ tạm",
                        _: "Đã sao chép %d dòng vào bộ nhớ tạm",
                    },
                    copyTitle: "Sao chép vào bộ nhớ tạm",
                    csv: "File CSV",
                    excel: "File Excel",
                    pageLength: {
                        "-1": "Xem tất cả các dòng",
                        _: "Hiển thị %d dòng",
                    },
                    pdf: "Tệp PDF",
                    print: "In",
                },
                infoThousands: ",",
                select: {
                    cells: {
                        1: "1 ô đang được chọn",
                        _: "%d ô đang được chọn",
                    },
                    columns: {
                        1: "1 cột đang được chọn",
                        _: "%d cột đang được được chọn",
                    },
                    rows: {
                        1: "1 dòng đang được chọn",
                        _: "%d dòng đang được chọn",
                    },
                },
                thousands: ",",
                searchBuilder: {
                    title: {
                        _: "Thiết lập tìm kiếm (%d)",
                        0: "Thiết lập tìm kiếm",
                    },
                    button: {
                        0: "Thiết lập tìm kiếm",
                        _: "Thiết lập tìm kiếm (%d)",
                    },
                    value: "Giá trị",
                    clearAll: "Xóa hết",
                    condition: "Điều kiện",
                    conditions: {
                        date: {
                            after: "Sau",
                            before: "Trước",
                            between: "Nằm giữa",
                            empty: "Rỗng",
                            equals: "Bằng với",
                            not: "Không phải",
                            notBetween: "Không nằm giữa",
                            notEmpty: "Không rỗng",
                        },
                        number: {
                            between: "Nằm giữa",
                            empty: "Rỗng",
                            equals: "Bằng với",
                            gt: "Lớn hơn",
                            gte: "Lớn hơn hoặc bằng",
                            lt: "Nhỏ hơn",
                            lte: "Nhỏ hơn hoặc bằng",
                            not: "Không phải",
                            notBetween: "Không nằm giữa",
                            notEmpty: "Không rỗng",
                        },
                        string: {
                            contains: "Chứa",
                            empty: "Rỗng",
                            endsWith: "Kết thúc bằng",
                            equals: "Bằng",
                            not: "Không phải",
                            notEmpty: "Không rỗng",
                            startsWith: "Bắt đầu với",
                        },
                    },
                    logicAnd: "Và",
                    logicOr: "Hoặc",
                    add: "Thêm điều kiện",
                    data: "Dữ liệu",
                    deleteTitle: "Xóa quy tắc lọc",
                },
                searchPanes: {
                    countFiltered: "{shown} ({total})",
                    emptyPanes: "Không có phần tìm kiếm",
                    clearMessage: "Xóa hết",
                    loadMessage: "Đang tải phần tìm kiếm",
                    collapse: {
                        0: "Phần tìm kiếm",
                        _: "Phần tìm kiếm (%d)",
                    },
                    title: "Bộ lọc đang hoạt động - %d",
                    count: "{total}",
                },
                datetime: {
                    hours: "Giờ",
                    minutes: "Phút",
                    next: "Sau",
                    previous: "Trước",
                    seconds: "Giây",
                },
                emptyTable: "Không có dữ liệu",
                info: "Hiển thị _START_ - _END_ (_TOTAL_ kết quả)",
                infoEmpty: "Trang 0",
                lengthMenu: "Hiển thị _MENU_ mục",
                loadingRecords: "Đang tải...",
                paginate: {
                    first: "<i class='a fa-angle-double-left'></i>",
                    previous: "<i class='fa fa-angle-left'></i>",
                    next: "<i class='fa fa-angle-right'></i>",
                    last: "<i class='fa fa-angle-double-right'></i>",
                },
                search: "_INPUT_",
                searchPlaceholder: "Tìm kiếm thông tin",
                zeroRecords: "Không tìm thấy kết quả",
            },
        });

        // Init full DataTable
        jQuery(".js-dataTable-full").dataTable({
            order: [[ 1, 'asc' ]],
            columnDefs: [{ 
                targets: 0, 
                orderable: false,
            }],
            pageLength: 10,
            autoWidth: false,
        });
    }

    /*
     * Init functionality
     *
     */
    static init() {
        this.initDataTables();
    }
}

// Initialize when page loads
jQuery(() => {
    TablesDatatables.init();
});
