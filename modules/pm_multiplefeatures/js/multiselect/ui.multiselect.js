/*
 * jQuery UI Multiselect
 *
 * Authors:
 *  Michael Aufreiter (quasipartikel.at)
 *  Yanick Rochon (yanick.rochon[at]gmail[dot]com)
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://yanickrochon.uuuq.com/multiselect/
 *
 *
 * Depends:
 *	 ui.core.js
 *  jquery.blockUI (http://github.com/malsup/blockui/)
 *  jquery.tmpl (http://andrew.hedges.name/blog/2008/09/03/introducing-jquery-simple-templates
 *
 * Optional:
 *  localization (http://plugins.jquery.com/project/localisation)
 *
 * Notes:
 *  The strings in this plugin use a templating engine to enable localization
 *  and allow flexibility in the messages. Read the documentation for more details.
 *
 * Todo:
 *  restore selected items on remote searchable multiselect upon page reload (same behavior as local mode)
 *  (is it worth it??) add a public function to apply the nodeComparator to all items (when using nodeComparator setter)
 *  support for option groups, disabled options, etc.
 *  speed improvements
 *  tests and optimizations
 *    - test getters/setters (including options from the defaults)
 */

/*
 * jQuery UI Multiselect
 *
 * Authors:
 *  Michael Aufreiter (quasipartikel.at)
 *  Yanick Rochon (yanick.rochon[at]gmail[dot]com)
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://www.quasipartikel.at/multiselect/
 *
 *
 * Depends:
 *	ui.core.js
 *
 * Optional:
 * localization (http://plugins.jquery.com/project/localisation)
 * scrollTo (http://plugins.jquery.com/project/ScrollTo)
 *
 * Todo:
 *  Make batch actions faster
 *  Implement dynamic insertion through remote calls
 */
var defaultDiacriticsRemovalMap = [
    {'base':'A', 'letters':/[\u0041\u24B6\uFF21\u00C0\u00C1\u00C2\u1EA6\u1EA4\u1EAA\u1EA8\u00C3\u0100\u0102\u1EB0\u1EAE\u1EB4\u1EB2\u0226\u01E0\u00C4\u01DE\u1EA2\u00C5\u01FA\u01CD\u0200\u0202\u1EA0\u1EAC\u1EB6\u1E00\u0104\u023A\u2C6F]/g},
    {'base':'AA','letters':/[\uA732]/g},
    {'base':'AE','letters':/[\u00C6\u01FC\u01E2]/g},
    {'base':'AO','letters':/[\uA734]/g},
    {'base':'AU','letters':/[\uA736]/g},
    {'base':'AV','letters':/[\uA738\uA73A]/g},
    {'base':'AY','letters':/[\uA73C]/g},
    {'base':'B', 'letters':/[\u0042\u24B7\uFF22\u1E02\u1E04\u1E06\u0243\u0182\u0181]/g},
    {'base':'C', 'letters':/[\u0043\u24B8\uFF23\u0106\u0108\u010A\u010C\u00C7\u1E08\u0187\u023B\uA73E]/g},
    {'base':'D', 'letters':/[\u0044\u24B9\uFF24\u1E0A\u010E\u1E0C\u1E10\u1E12\u1E0E\u0110\u018B\u018A\u0189\uA779]/g},
    {'base':'DZ','letters':/[\u01F1\u01C4]/g},
    {'base':'Dz','letters':/[\u01F2\u01C5]/g},
    {'base':'E', 'letters':/[\u0045\u24BA\uFF25\u00C8\u00C9\u00CA\u1EC0\u1EBE\u1EC4\u1EC2\u1EBC\u0112\u1E14\u1E16\u0114\u0116\u00CB\u1EBA\u011A\u0204\u0206\u1EB8\u1EC6\u0228\u1E1C\u0118\u1E18\u1E1A\u0190\u018E]/g},
    {'base':'F', 'letters':/[\u0046\u24BB\uFF26\u1E1E\u0191\uA77B]/g},
    {'base':'G', 'letters':/[\u0047\u24BC\uFF27\u01F4\u011C\u1E20\u011E\u0120\u01E6\u0122\u01E4\u0193\uA7A0\uA77D\uA77E]/g},
    {'base':'H', 'letters':/[\u0048\u24BD\uFF28\u0124\u1E22\u1E26\u021E\u1E24\u1E28\u1E2A\u0126\u2C67\u2C75\uA78D]/g},
    {'base':'I', 'letters':/[\u0049\u24BE\uFF29\u00CC\u00CD\u00CE\u0128\u012A\u012C\u0130\u00CF\u1E2E\u1EC8\u01CF\u0208\u020A\u1ECA\u012E\u1E2C\u0197]/g},
    {'base':'J', 'letters':/[\u004A\u24BF\uFF2A\u0134\u0248]/g},
    {'base':'K', 'letters':/[\u004B\u24C0\uFF2B\u1E30\u01E8\u1E32\u0136\u1E34\u0198\u2C69\uA740\uA742\uA744\uA7A2]/g},
    {'base':'L', 'letters':/[\u004C\u24C1\uFF2C\u013F\u0139\u013D\u1E36\u1E38\u013B\u1E3C\u1E3A\u0141\u023D\u2C62\u2C60\uA748\uA746\uA780]/g},
    {'base':'LJ','letters':/[\u01C7]/g},
    {'base':'Lj','letters':/[\u01C8]/g},
    {'base':'M', 'letters':/[\u004D\u24C2\uFF2D\u1E3E\u1E40\u1E42\u2C6E\u019C]/g},
    {'base':'N', 'letters':/[\u004E\u24C3\uFF2E\u01F8\u0143\u00D1\u1E44\u0147\u1E46\u0145\u1E4A\u1E48\u0220\u019D\uA790\uA7A4]/g},
    {'base':'NJ','letters':/[\u01CA]/g},
    {'base':'Nj','letters':/[\u01CB]/g},
    {'base':'O', 'letters':/[\u004F\u24C4\uFF2F\u00D2\u00D3\u00D4\u1ED2\u1ED0\u1ED6\u1ED4\u00D5\u1E4C\u022C\u1E4E\u014C\u1E50\u1E52\u014E\u022E\u0230\u00D6\u022A\u1ECE\u0150\u01D1\u020C\u020E\u01A0\u1EDC\u1EDA\u1EE0\u1EDE\u1EE2\u1ECC\u1ED8\u01EA\u01EC\u00D8\u01FE\u0186\u019F\uA74A\uA74C]/g},
    {'base':'OI','letters':/[\u01A2]/g},
    {'base':'OO','letters':/[\uA74E]/g},
    {'base':'OU','letters':/[\u0222]/g},
    {'base':'P', 'letters':/[\u0050\u24C5\uFF30\u1E54\u1E56\u01A4\u2C63\uA750\uA752\uA754]/g},
    {'base':'Q', 'letters':/[\u0051\u24C6\uFF31\uA756\uA758\u024A]/g},
    {'base':'R', 'letters':/[\u0052\u24C7\uFF32\u0154\u1E58\u0158\u0210\u0212\u1E5A\u1E5C\u0156\u1E5E\u024C\u2C64\uA75A\uA7A6\uA782]/g},
    {'base':'S', 'letters':/[\u0053\u24C8\uFF33\u1E9E\u015A\u1E64\u015C\u1E60\u0160\u1E66\u1E62\u1E68\u0218\u015E\u2C7E\uA7A8\uA784]/g},
    {'base':'T', 'letters':/[\u0054\u24C9\uFF34\u1E6A\u0164\u1E6C\u021A\u0162\u1E70\u1E6E\u0166\u01AC\u01AE\u023E\uA786]/g},
    {'base':'TZ','letters':/[\uA728]/g},
    {'base':'U', 'letters':/[\u0055\u24CA\uFF35\u00D9\u00DA\u00DB\u0168\u1E78\u016A\u1E7A\u016C\u00DC\u01DB\u01D7\u01D5\u01D9\u1EE6\u016E\u0170\u01D3\u0214\u0216\u01AF\u1EEA\u1EE8\u1EEE\u1EEC\u1EF0\u1EE4\u1E72\u0172\u1E76\u1E74\u0244]/g},
    {'base':'V', 'letters':/[\u0056\u24CB\uFF36\u1E7C\u1E7E\u01B2\uA75E\u0245]/g},
    {'base':'VY','letters':/[\uA760]/g},
    {'base':'W', 'letters':/[\u0057\u24CC\uFF37\u1E80\u1E82\u0174\u1E86\u1E84\u1E88\u2C72]/g},
    {'base':'X', 'letters':/[\u0058\u24CD\uFF38\u1E8A\u1E8C]/g},
    {'base':'Y', 'letters':/[\u0059\u24CE\uFF39\u1EF2\u00DD\u0176\u1EF8\u0232\u1E8E\u0178\u1EF6\u1EF4\u01B3\u024E\u1EFE]/g},
    {'base':'Z', 'letters':/[\u005A\u24CF\uFF3A\u0179\u1E90\u017B\u017D\u1E92\u1E94\u01B5\u0224\u2C7F\u2C6B\uA762]/g},
    {'base':'a', 'letters':/[\u0061\u24D0\uFF41\u1E9A\u00E0\u00E1\u00E2\u1EA7\u1EA5\u1EAB\u1EA9\u00E3\u0101\u0103\u1EB1\u1EAF\u1EB5\u1EB3\u0227\u01E1\u00E4\u01DF\u1EA3\u00E5\u01FB\u01CE\u0201\u0203\u1EA1\u1EAD\u1EB7\u1E01\u0105\u2C65\u0250]/g},
    {'base':'aa','letters':/[\uA733]/g},
    {'base':'ae','letters':/[\u00E6\u01FD\u01E3]/g},
    {'base':'ao','letters':/[\uA735]/g},
    {'base':'au','letters':/[\uA737]/g},
    {'base':'av','letters':/[\uA739\uA73B]/g},
    {'base':'ay','letters':/[\uA73D]/g},
    {'base':'b', 'letters':/[\u0062\u24D1\uFF42\u1E03\u1E05\u1E07\u0180\u0183\u0253]/g},
    {'base':'c', 'letters':/[\u0063\u24D2\uFF43\u0107\u0109\u010B\u010D\u00E7\u1E09\u0188\u023C\uA73F\u2184]/g},
    {'base':'d', 'letters':/[\u0064\u24D3\uFF44\u1E0B\u010F\u1E0D\u1E11\u1E13\u1E0F\u0111\u018C\u0256\u0257\uA77A]/g},
    {'base':'dz','letters':/[\u01F3\u01C6]/g},
    {'base':'e', 'letters':/[\u0065\u24D4\uFF45\u00E8\u00E9\u00EA\u1EC1\u1EBF\u1EC5\u1EC3\u1EBD\u0113\u1E15\u1E17\u0115\u0117\u00EB\u1EBB\u011B\u0205\u0207\u1EB9\u1EC7\u0229\u1E1D\u0119\u1E19\u1E1B\u0247\u025B\u01DD]/g},
    {'base':'f', 'letters':/[\u0066\u24D5\uFF46\u1E1F\u0192\uA77C]/g},
    {'base':'g', 'letters':/[\u0067\u24D6\uFF47\u01F5\u011D\u1E21\u011F\u0121\u01E7\u0123\u01E5\u0260\uA7A1\u1D79\uA77F]/g},
    {'base':'h', 'letters':/[\u0068\u24D7\uFF48\u0125\u1E23\u1E27\u021F\u1E25\u1E29\u1E2B\u1E96\u0127\u2C68\u2C76\u0265]/g},
    {'base':'hv','letters':/[\u0195]/g},
    {'base':'i', 'letters':/[\u0069\u24D8\uFF49\u00EC\u00ED\u00EE\u0129\u012B\u012D\u00EF\u1E2F\u1EC9\u01D0\u0209\u020B\u1ECB\u012F\u1E2D\u0268\u0131]/g},
    {'base':'j', 'letters':/[\u006A\u24D9\uFF4A\u0135\u01F0\u0249]/g},
    {'base':'k', 'letters':/[\u006B\u24DA\uFF4B\u1E31\u01E9\u1E33\u0137\u1E35\u0199\u2C6A\uA741\uA743\uA745\uA7A3]/g},
    {'base':'l', 'letters':/[\u006C\u24DB\uFF4C\u0140\u013A\u013E\u1E37\u1E39\u013C\u1E3D\u1E3B\u017F\u0142\u019A\u026B\u2C61\uA749\uA781\uA747]/g},
    {'base':'lj','letters':/[\u01C9]/g},
    {'base':'m', 'letters':/[\u006D\u24DC\uFF4D\u1E3F\u1E41\u1E43\u0271\u026F]/g},
    {'base':'n', 'letters':/[\u006E\u24DD\uFF4E\u01F9\u0144\u00F1\u1E45\u0148\u1E47\u0146\u1E4B\u1E49\u019E\u0272\u0149\uA791\uA7A5]/g},
    {'base':'nj','letters':/[\u01CC]/g},
    {'base':'o', 'letters':/[\u006F\u24DE\uFF4F\u00F2\u00F3\u00F4\u1ED3\u1ED1\u1ED7\u1ED5\u00F5\u1E4D\u022D\u1E4F\u014D\u1E51\u1E53\u014F\u022F\u0231\u00F6\u022B\u1ECF\u0151\u01D2\u020D\u020F\u01A1\u1EDD\u1EDB\u1EE1\u1EDF\u1EE3\u1ECD\u1ED9\u01EB\u01ED\u00F8\u01FF\u0254\uA74B\uA74D\u0275]/g},
    {'base':'oi','letters':/[\u01A3]/g},
    {'base':'ou','letters':/[\u0223]/g},
    {'base':'oo','letters':/[\uA74F]/g},
    {'base':'p','letters':/[\u0070\u24DF\uFF50\u1E55\u1E57\u01A5\u1D7D\uA751\uA753\uA755]/g},
    {'base':'q','letters':/[\u0071\u24E0\uFF51\u024B\uA757\uA759]/g},
    {'base':'r','letters':/[\u0072\u24E1\uFF52\u0155\u1E59\u0159\u0211\u0213\u1E5B\u1E5D\u0157\u1E5F\u024D\u027D\uA75B\uA7A7\uA783]/g},
    {'base':'s','letters':/[\u0073\u24E2\uFF53\u00DF\u015B\u1E65\u015D\u1E61\u0161\u1E67\u1E63\u1E69\u0219\u015F\u023F\uA7A9\uA785\u1E9B]/g},
    {'base':'t','letters':/[\u0074\u24E3\uFF54\u1E6B\u1E97\u0165\u1E6D\u021B\u0163\u1E71\u1E6F\u0167\u01AD\u0288\u2C66\uA787]/g},
    {'base':'tz','letters':/[\uA729]/g},
    {'base':'u','letters':/[\u0075\u24E4\uFF55\u00F9\u00FA\u00FB\u0169\u1E79\u016B\u1E7B\u016D\u00FC\u01DC\u01D8\u01D6\u01DA\u1EE7\u016F\u0171\u01D4\u0215\u0217\u01B0\u1EEB\u1EE9\u1EEF\u1EED\u1EF1\u1EE5\u1E73\u0173\u1E77\u1E75\u0289]/g},
    {'base':'v','letters':/[\u0076\u24E5\uFF56\u1E7D\u1E7F\u028B\uA75F\u028C]/g},
    {'base':'vy','letters':/[\uA761]/g},
    {'base':'w','letters':/[\u0077\u24E6\uFF57\u1E81\u1E83\u0175\u1E87\u1E85\u1E98\u1E89\u2C73]/g},
    {'base':'x','letters':/[\u0078\u24E7\uFF58\u1E8B\u1E8D]/g},
    {'base':'y','letters':/[\u0079\u24E8\uFF59\u1EF3\u00FD\u0177\u1EF9\u0233\u1E8F\u00FF\u1EF7\u1E99\u1EF5\u01B4\u024F\u1EFF]/g},
    {'base':'z','letters':/[\u007A\u24E9\uFF5A\u017A\u1E91\u017C\u017E\u1E93\u1E95\u01B6\u0225\u0240\u2C6C\uA763]/g}
];
var changes;
function removeDiacritics (str) {
    if(!changes) {
        changes = defaultDiacriticsRemovalMap;
    }
    for(var i=0; i<changes.length; i++) {
        str = str.replace(changes[i].letters, changes[i].base);
    }
    return str;
}
/********************************
 *  Default callbacks
 ********************************/

// expect data to be "val1=text1[\nval2=text2[\n...]]"
var defaultDataParser = function(data) {
	if ( typeof data == 'string' ) {
		var pattern = /^(\s\n\r\t)*\+?$/;
		var selected, line, lines = data.split(/\n/);
		data = {};
		for (var i in lines) {
			line = lines[i].split("=");
			// make sure the key is not empty
			if (!pattern.test(line[0])) {
				selected = (line[0].lastIndexOf('+') == line.length - 1);
				if (selected) line[0] = line.substr(0,line.length-1);
				// if no value is specified, default to the key value
				data[line[0]] = {
					selected: false,
					value: line[1] || line[0]
				};
			}
		}
	} else {
		this._messages($.ui.multiselect.constante.MESSAGE_ERROR, $.ui.multiselect.locale.errorDataFormat);
		data = false;
	}
	return data;
};

var defaultNodeComparator = function(node1,node2) {
	var text1 = node1.text(),
	    text2 = node2.text();
	return text1 == text2 ? 0 : (text1 < text2 ? -1 : 1);
};

(function($) {

$.widget("ui.multiselect", {
  options: {
		// searchable
		searchable: true,
		searchDelay: 400,
		searchAtStart: false,
		remoteUrl: null,
		remoteParams: {},
		remoteLimit: 50,
		simpleClickable: true,
		remoteLimitIncrement: 20,
		remoteStart: 0,
		// animated
		animated: 'fast',
		show: 'slideDown',
		hide: 'slideUp',
		// ui
		dividerLocation: 0.6,
		// callbacks
		dataParser: defaultDataParser,
		nodeComparator: defaultNodeComparator,
		nodeInserted: null,
		sInputSearch:'Please enter the first letters of the search item',
		sInputShowMore: 'Show more'
	},
	_create: function() {
		this.elementWidth = this.element.width();
		this.elementHeight = this.element.height();
		this.element.hide();
		this.busy = false;  // busy state
		this.idMultiSelect = this._uniqid();  // busy state
		this.container = $('<div class="ui-multiselect ui-helper-clearfix ui-widget"></div>').insertAfter(this.element);
		this.selectedContainer = $('<div class="ui-widget-content list-container selected"></div>').appendTo(this.container);
		this.availableContainer = $('<div class="ui-widget-content list-container available"></div>').appendTo(this.container);
		this.selectedActions = $('<div class="actions ui-widget-header ui-helper-clearfix"><span class="count">'+$.tmpl($.ui.multiselect.locale.itemsCount,{count:0})+'</span><a href="#" class="remove-all">'+$.tmpl($.ui.multiselect.locale.removeAll)+'</a></div>').appendTo(this.selectedContainer);
		this.availableActions = $('<div class="actions ui-widget-header ui-helper-clearfix"><span class="busy">'+$.tmpl($.ui.multiselect.locale.busy)+'</span><input type="text" class="search ui-widget-content ui-corner-all"  value="'+this.options.sInputSearch+'" onfocus="javascript:if(this.value==\''+this.options.sInputSearch+'\')this.value=\'\';" onblur="javascript:if(this.value==\'\')this.value=\''+this.options.sInputSearch+'\';" /><a href="#" class="add-all">'+$.tmpl($.ui.multiselect.locale.addAll)+'</a></div>').appendTo(this.availableContainer);
		this.selectedList = $('<ul class="list selected"><li class="ui-helper-hidden-accessible"></li></ul>').bind('selectstart', function(){return false;}).appendTo(this.selectedContainer);
		this.availableList = $('<ul class="list available"><li class="ui-helper-hidden-accessible"></li></ul>').bind('selectstart', function(){return false;}).appendTo(this.availableContainer);

		var that = this;

		// initialize data cache
		this.availableList.data('multiselect.cache', {});
		this.selectedList.data('multiselect.cache', {});

		if ( !this.options.animated ) {
			this.options.show = 'show';
			this.options.hide = 'hide';
		}

		this._prepareLists('selected', 'available');
		this._prepareLists('available', 'selected');

		// set up livesearch
		var valSearch = this.availableContainer.find('input.search').val();
		this.availableContainer.find('input.search').val('');
		this._registerSearchEvents(this.availableContainer.find('input.search'), this.options.searchAtStart);
		this.availableContainer.find('input.search').val(valSearch);
		// make sure that we're not busy yet
		this._setBusy(false);

		// batch actions
		this.container.find(".remove-all").bind('click.multiselect', function() { that.selectNone(); return false; });
		this.container.find(".add-all").bind('click.multiselect', function() { that.selectAll(); return false; });

		// set dimensions
		this.container.width(this.elementWidth+1);
		this._refreshDividerLocation();
		// set max width of search input dynamically
		this.availableActions.find('input').width(Math.max(this.availableActions.width() - this.availableActions.find('a.add-all').width() - 30, 20));
		// fix list height to match <option> depending on their individual header's heights
		this.selectedList.height(Math.max(this.elementHeight-this.selectedActions.height(),1));
		this.availableList.height(Math.max(this.elementHeight-this.availableActions.height(),1));

		// init lists
		this._populateLists(this.element.find('option'));
	},
	_uniqid: function() {
		var newDate = new Date;
	    return newDate.getTime();
	},
	/**************************************
    *  Public
    **************************************/

	destroy: function() {
		this.container.remove();
		this.element.show();

		$.widget.prototype.destroy.apply(this, arguments);
	},
	isBusy: function() {
		return !!this.busy;
	},
	isSelected: function(item) {
		if (this.enabled()) {
			return !!this._findItem(item, this.selectedList);
		} else {
			return null;
		}
	},
	// get all selected values in an array
	selectedValues: function() {
		return $.map( this.element.find('option[selected]'), function(item,i) { return $(item).val(); });
	},
	// get/set enable state
	enabled: function(state, msg) {
		if (undefined !== state) {
			if (state) {
				this.container.unblock();
				this.element.removeAttr('disabled');
			} else {
				this.container.block({message:msg||null,overlayCSS:{backgroundColor:'#fff',opacity:0.4,cursor:'default'}});
				this.element.attr('disabled', true);
			}
		}
		return !this.element.attr('disabled');
	},
	selectAll: function() {
		if (this.enabled()) {
			this._batchSelect(this.availableList.children('li.ui-element:visible'), true);
		}
	},
	selectNone: function() {
		if (this.enabled()) {
			this._batchSelect(this.selectedList.children('li.ui-element:visible'), false);
		}
	},
	select: function(text) {
		if (this.enabled()) {
			var available = this._findItem(text, this.availableList);
			if ( available ) {
				this._setSelected(available, true);
			}
		}
	},
	deselect: function(text) {
		if (this.enabled()) {
			var selected = this._findItem(text, this.selectedList);
			if ( selected ) {
				this._setSelected(selected, false);
			}
		}
	},
	search: function(query) {
		if (!this.busy && this.enabled() && this.options.searchable) {
			var input = this.availableActions.children('input:first');
			input.val(query);
			input.trigger('keydown.multiselect');
		}
	},
	// insert new <option> and _populate
	// @return int   the number of options added
	addOptions: function(data) {
		if (this.enabled()) {
			this._setBusy(true);
			var displayMore = false;
			// format data
			var elements = [];
			if (data = this.options.dataParser.call(this, data)) {
				for (var key in data) {
					if(key == 'DisplayMore') {
						var displayMore = true;
					}
					else {
						// check if the option does not exist already
						if (this.element.find('option[value="'+key+'"]').size()==0) {
							elements.push( $('<option value="'+key+'"/>').text(data[key].value).appendTo(this.element)[0] );
						}
					}
				}
			}

			if (elements.length>0) {
				this._populateLists($(elements));
			}


			this._filter(this.availableList.children('li.ui-element'));
			if(!$('#multiselectShowMore_'+this.idMultiSelect).length && displayMore) {
				var showMoreLink = $('<p id="multiselectShowMore_'+this.idMultiSelect+'"><a href="javascript:void(0);">'+this.options.sInputShowMore+'</a></p>');
				this.availableList.after(showMoreLink);
				var that = this;
				showMoreLink.unbind('click').bind('click', function() {
					that.options.remoteStart += that.options.remoteLimit;
					that.options.remoteLimit = that.options.remoteLimitIncrement;
					that._registerSearchEvents(that.availableContainer.find('input.search'), true);
				});

			}
			else if(!displayMore && $('#multiselectShowMore_'+this.idMultiSelect).length) {
				$('#multiselectShowMore_'+this.idMultiSelect).fadeOut('fast',function() {$(this).remove();});
			}
			this._setBusy(false);
			return elements.length;
		} else {
			return false;
		}
	},

	/**************************************
    *  Private
    **************************************/

	_setData: function(key, value) {
		switch (key) {
			// special treatement must be done for theses values when changed
			case 'dividerLocation':
				this.options.dividerLocation = value;
				this._refreshDividerLocation();
				break;
			case 'searchable':
				this.options.searchable = value;
				this._registerSearchEvents(this.availableContainer.find('input.search'), false);
				break;
			default:
				// default behavior
				this.options[key] = value;
				break;
		}
	},
	_ui: function(type) {
		var uiObject = {sender: this.element};
		switch (type) {
			// events: messages
			case 'message':
				uiObject.type = arguments[1];
				uiObject.message = arguments[2];
				break;

			// events: selected, deselected
			case 'selection':
				uiObject.option = arguments[1];
				break;
		}
		return uiObject;
	},
	_messages: function(type, msg, params) {
		this._trigger('messages', null, this._ui('message', type, $.tmpl(msg, params)));
	},

	_refreshDividerLocation: function() {
		this.selectedContainer.width(Math.floor(this.elementWidth*this.options.dividerLocation));
		this.availableContainer.width(Math.floor(this.elementWidth*(1-this.options.dividerLocation)));
	},
	_prepareLists: function(side, otherSide) {
		var that = this;
		var itemSelected = ('selected' == side);
		var list = this[side+'List'];
		var otherList = this[otherSide+'List'];
	},
	_populateLists: function(options) {
		this._setBusy(true);

		var that = this;
		// do this async so the browser actually display the waiting message
		setTimeout(function() {
			$(options.each(function(i) {
				var list = (this.selected ? that.selectedList : that.availableList);
		      var item = that._getOptionNode(this).show();
				that._applyItemState(item, this.selected);
				item.data('multiselect.idx', i);

				// cache
				list.data('multiselect.cache')[item.data('multiselect.optionLink').val()] = item;

				that._insertToList(item, list);
		    }));

			// update count
			that._setBusy(false);
			that._updateCount();
		}, 1);
	},
	_insertToList: function(node, list) {
		var that = this;
		this._setBusy(true);
		// the browsers don't like batch node insertion...
		var _addNodeRetry = 0;
		var _addNode = function() {
			var succ = (that.options.nodeComparator ? that._getSuccessorNode(node, list) : null);
			try {
				if (succ) {
					node.insertBefore(succ);
				} else {
					list.append(node);
				}
				if (list === that.selectedList) that._moveOptionNode(node);

				// callback after node insertion
				if ('function' == typeof that.options.nodeInserted) that.options.nodeInserted(node);
				that._setBusy(false);
			} catch (e) {
				// if this problem did not occur too many times already
				if ( _addNodeRetry++ < 10 ) {
					// try again later (let the browser cool down first)
					setTimeout(function() { _addNode(); }, 1);
				} else {
					that._messages(
						$.ui.multiselect.constants.MESSAGE_EXCEPTION,
						$.ui.multiselect.locale.errorInsertNode,
						{key:node.data('multiselect.optionLink').val(), value:node.text()}
					);
					that._setBusy(false);
				}
			}
		};
		_addNode();
	},
	_updateCount: function() {
		var that = this;
		// defer until system is not busy
		if (this.busy) setTimeout(function() { that._updateCount(); }, 100);
		// count only visible <li> (less .ui-helper-hidden*)
		var count = this.selectedList.children('li:not(.ui-helper-hidden-accessible,.ui-sortable-placeholder):visible').size();
		var total = this.availableList.children('li:not(.ui-helper-hidden-accessible,.ui-sortable-placeholder,.shadowed)').size() + count;
		this.selectedContainer.find('span.count')
			.html($.tmpl($.ui.multiselect.locale.itemsCount, {count:count}))
			.attr('title', $.tmpl($.ui.multiselect.locale.itemsTotal, {count:total}));

	},
	_getOptionNode: function(option) {
		option = $(option);
		var node = $('<li class="ui-state-default ui-element"><span class="ui-icon"/>'+option.text()+'<a href="#" class="ui-state-default action"><span class="ui-corner-all ui-icon"/></a></li>').hide();
		node.data('multiselect.optionLink', option);
		return node;
	},
	_moveOptionNode: function(item) {
		// call this async to let the item be placed correctly
		setTimeout( function() {
			var optionLink = item.data('multiselect.optionLink');
			if (optionLink) {
				var prevItem = item.prev('li:not(.ui-helper-hidden-accessible,.ui-sortable-placeholder):visible');
				var prevOptionLink = prevItem.size() ? prevItem.data('multiselect.optionLink') : null;

				if (prevOptionLink) {
					optionLink.insertAfter(prevOptionLink);
				} else {
					optionLink.prependTo(optionLink.parent());
				}
			}
		}, 100);
	},
	// used by select and deselect, etc.
	_findItem: function(text, list) {
		var found = null;
		list.children('li.ui-element:visible').each(function(i,el) {
			el = $(el);
			/*if (el.text().toLowerCase() === text.toLowerCase()) {*/
			if (escape(el.text().toLowerCase()) === escape(text.toLowerCase())) {
				found = el;
			}
		});
		if (found && found.size()) {
			return found;
		} else {
			return false;
		}
	},
	// clones an item with
	// didn't find a smarter away around this (michael)
	// now using cache to speed up the process (yr)
	_cloneWithData: function(clonee, cacheName, insertItem) {
		var that = this;
		var id = clonee.data('multiselect.optionLink').val();
		var selected = ('selected' == cacheName);
		var list = (selected ? this.selectedList : this.availableList);
		var clone = list.data('multiselect.cache')[id];

		if (!clone) {
			clone = clonee.clone().hide();
			this._applyItemState(clone, selected);
			// update cache
			list.data('multiselect.cache')[id] = clone;
			// update <option> and idx
			clone.data('multiselect.optionLink', clonee.data('multiselect.optionLink'));
			// need this here because idx is needed in _getSuccessorNode
			clone.data('multiselect.idx', clonee.data('multiselect.idx'));

			// insert the node into it's list
			if (insertItem) {
				this._insertToList(clone, list);
			}
		} else {
			// update idx
			clone.data('multiselect.idx', clonee.data('multiselect.idx'));
		}
		return clone;
	},
	_batchSelect: function(elements, state) {
		this._setBusy(true);

		var that = this;
		// do this async so the browser actually display the waiting message
		setTimeout(function() {
			var _backup = {
				animated: that.options.animated,
				hide: that.options.hide,
				show: that.options.show
			};

			that.options.animated = null;
			that.options.hide = 'hide';
			that.options.show = 'show';

			elements.each(function(i,element) {
				that._setSelected($(element), state);
			});

			// filter available items
			if (!state) that._filter(that.availableList.find('li.ui-element'));

			// restore
			$.extend(that.options, _backup);

			that._updateCount();
			that._setBusy(false);
		}, 10);
	},
	// find the best successor the given item in the specified list
	// TODO implement a faster sorting algorithm (and remove the idx dependancy)
	_getSuccessorNode: function(item, list) {
		// look for successor based on initial option index
		var items = list.find('li.ui-element'), comparator = this.options.nodeComparator;
		var itemsSize = items.size();

		// no successor, list is null
		if (items.size() == 0) return null;

		var succ, i = Math.min(item.data('multiselect.idx'),itemsSize-1), direction = comparator(item, $(items[i]));

		if ( direction ) {
			// quick checks
			if (0>direction && 0>=i) {
				succ = items[0];
			} else if (0<direction && itemsSize-1<=i) {
				i++;
				succ = null;
			} else {
				while (i>=0 && i<items.length) {
					direction > 0 ? i++ : i--;
					if (i<0) {
						succ = item[0]
					}
					if ( direction != comparator(item, $(items[i])) ) {
						// going up, go back one item down, otherwise leave as is
						succ = items[direction > 0 ? i : i+1];
						break;
					}
				}
			}
		} else {
			succ = items[i];
		}
		// update idx
		item.data('multiselect.idx', i);

		return succ;
	},
	// @param DOMElement item         is the item to set
   // @param bool selected           true|false (state)
   // @param bool noclone (optional) true only if item should not be cloned on the other list
	_setSelected: function(item, selected, noclone) {
		var that = this, otherItem;
		var optionLink = item.data('multiselect.optionLink');

		if (selected) {
			// already selected
			if (optionLink.attr('selected')) return;
			optionLink.attr('selected','selected');

			if (noclone) {
				otherItem = item;
			} else {
				// retrieve associatd or cloned item
				otherItem = this._cloneWithData(item, 'selected', true).hide();
				item.addClass('shadowed')[this.options.hide](this.options.animated, function() { that._updateCount(); });
			}
			otherItem[this.options.show](this.options.animated);
		} else {
			// already deselected
			if (!optionLink.attr('selected')) return;
			optionLink.removeAttr('selected');

			if (noclone) {
				otherItem = item;
			} else {
				// retrieve associated or clone the item
				otherItem = this._cloneWithData(item, 'available', true).hide().removeClass('shadowed');
				item[this.options.hide](this.options.animated, function() { that._updateCount() });
			}
			if (!otherItem.is('.filtered')) otherItem[this.options.show](this.options.animated);
		}

		if (!this.busy) {
			if (this.options.animated) {
				// pulse
				//otherItem.effect("pulsate", { times: 1, mode: 'show' }, 400);  // pulsate twice???
				otherItem.fadeTo('fast', 0.3, function() { $(this).fadeTo('fast', 1); });
			}
		}

		// fire selection event
		this._trigger(selected ? 'selected' : 'deselected', null, this._ui('selection', optionLink));

		return otherItem;
	},
	_setBusy: function(state) {
		var input = this.availableActions.children('input.search');
		var busy = this.availableActions.children('.busy');

		this.busy = Math.max(state ? ++this.busy : --this.busy, 0);

		this.container.find("a.remove-all, a.add-all")[this.busy ? 'hide' : 'show']();
		if (state && (1 == this.busy)) {
			if (this.options.searchable) {
				// backup input state
				input.data('multiselect.hadFocus', input.data('multiselect.hasFocus'));
				// webkit needs to blur before hiding or it won't fire focus again in the else block
				input.blur().hide();
			}
			busy.show();
		} else if(!this.busy) {
			if (this.options.searchable) {
				input.show();
				if (input.data('multiselect.hadFocus')) input.focus();
			}
			busy.hide();
		}

		// DEBUG
		//this._messages(0, "Busy state changed to : " + this.busy);
	},
	_applyItemState: function(item, selected) {
		if (selected) {
			item.children('span').addClass('ui-helper-hidden').removeClass('ui-icon');
			item.find('a.action span').addClass('ui-icon-minus').removeClass('ui-icon-plus');
			this._registerRemoveEvents(item.find('a.action'));

		} else {
			item.children('span').addClass('ui-helper-hidden').removeClass('ui-icon');
			item.find('a.action span').addClass('ui-icon-plus').removeClass('ui-icon-minus');
			this._registerAddEvents(item.find('a.action'));
		}

		this._registerSimpleClickEvents(item);
		this._registerHoverEvents(item);

		return item;
	},
	// apply filter and return elements
	_filter: function(elements) {
		var input = this.availableActions.children('input.search');
		//var term = removeDiacritics($.trim( input.val().toLowerCase() ));
		var term = $.trim( input.val().toLowerCase() );
		if ( !term ) {
			elements.removeClass('filtered');
		} else {
			elements.each(function(i,element) {
				element = $(element);
				//element[(element.text().toLowerCase().indexOf(term)>=0 ? 'remove' : 'add')+'Class']('filtered');
				element[(escape(element.text().toLowerCase()).indexOf(escape(term))>=0 ? 'remove' : 'add')+'Class']('filtered');
			});
		}

		return elements.not('.filtered, .shadowed').show().end().filter('.filtered, .shadowed').hide().end();
	},
	_registerSimpleClickEvents: function(elements) {
		if (!this.options.simpleClickable) return;
		var e = this;
		elements.click(function() {
			e.element.trigger('change');
			elements.find('a.action').click();

		});
	},
	_registerHoverEvents: function(elements) {
		elements
			.unbind('mouseover.multiselect').bind('mouseover.multiselect', function() {
				$(this).find('a').andSelf().addClass('ui-state-hover');
			})
			.unbind('mouseout.multiselect').bind('mouseout.multiselect', function() {
				$(this).find('a').andSelf().removeClass('ui-state-hover');
			})
			.find('a').andSelf().removeClass('ui-state-hover')
		;
	},
	_registerAddEvents: function(elements) {
		var that = this;
		elements.unbind('click.multiselect').bind('click.multiselect', function() {
			// ignore if busy...
			if (!this.busy) {
				that._setSelected($(this).parent(), true);
			}
			return false;
		});
	},
	_registerRemoveEvents: function(elements) {
		var that = this;
		elements.unbind('click.multiselect').bind('click.multiselect', function() {
			// ignore if busy...
			if (!that.busy) {
				that._setSelected($(this).parent(), false);
			}
			return false;
		});
 	},
	_registerSearchEvents: function(input, searchNow) {
		var that = this;
		var previousValue = input.val(), timer;

		var _searchNow = function(forceUpdate) {
			if (that.busy) return;

			var value = input.val();
			if (value == '' || (value != previousValue) || (forceUpdate)) {
				that._setBusy(true);

				if (that.options.remoteUrl) {
					var params = $.extend({}, that.options.remoteParams);
					try {
						$.ajax({
							url: that.options.remoteUrl,
							data: $.extend(params, {q:escape(value), start:that.options.remoteStart, limit:that.options.remoteLimit}),
							success: function(data) {
								that.addOptions(data);
								that._setBusy(false);
							},
							error: function(request,status,e) {
								that._messages(
									$.ui.multiselect.constants.MESSAGE_ERROR,
									$.ui.multiselect.locale.errorRequest,
									{status:status}
								);
								that._setBusy(false);
							}
						});
					} catch (e) {
						that._messages($.ui.multiselect.constants.MESSAGE_EXCEPTION, e.message);   // error message template ??
						that._setBusy(false);
					}
				} else {
					that._filter(that.availableList.children('li.ui-element'));
					that._setBusy(false);
				}

				previousValue = value;
			}
		};

		// reset any events... if any
		input.unbind('focus.multiselect blur.multiselect keydown.multiselect keypress.multiselect');
		if (this.options.searchable) {
			input
			.bind('focus.multiselect', function() {
				$(this).addClass('ui-state-active').data('multiselect.hasFocus', true);
			})
			.bind('blur.multiselect', function() {
				$(this).removeClass('ui-state-active').data('multiselect.hasFocus', false);
			})
			.bind('keydown.multiselect keypress.multiselect', function(e) {
				if (timer) clearTimeout(timer);
				switch (e.which) {
					case 13:   // enter
						_searchNow(true);
						return false;

					default:
						timer = setTimeout(function() { _searchNow(); }, Math.max(that.options.searchDelay,1));
				}
			})
			.show();
		} else {
			input.val('').hide();
			this._filter(that.availableList.find('li.ui-element'))
		}
		// initiate search filter (delayed)
		var _initSearch = function() {
			if (that.busy) {
				setTimeout(function() { _initSearch(); }, 100);
			}
			_searchNow(true);
		};

		if (searchNow) _initSearch();
	}
});
// END ui.multiselect

/****************************
 *  Settings
 ****************************/

$.extend($.ui.multiselect, {
	getter: 'selectedValues enabled isBusy',
	locale: {
		addAll:'Add all',
		removeAll:'Remove all',
		itemsCount:'#{count} items selected',
		itemsTotal:'#{count} items total',
		busy:'please wait...',
		errorDataFormat:"Cannot add options, unknown data format",
		errorInsertNode:"There was a problem trying to add the item:\n\n\t[#{key}] => #{value}\n\nThe operation was aborted.",
		errorReadonly:"The option #{option} is readonly",
		errorRequest:"Sorry! There seemed to be a problem with the remote call. (Type: #{status})"
	},
	constants: {
		MESSAGE_WARNING: 0,
		MESSAGE_EXCEPTION: 1,
		MESSAGE_ERROR: 2
	}
});

})(jQuery);