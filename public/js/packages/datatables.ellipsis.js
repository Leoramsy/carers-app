/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.fn.dataTable.render.ellipsis = function (cutoff) {
    return function (data, type, row) {
        return type === 'display' && data.length > cutoff ? data.substr(0, cutoff) + '…' : data;
    }
};