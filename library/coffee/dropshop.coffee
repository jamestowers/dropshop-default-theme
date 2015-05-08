class @Dropshop

  constructor: ->
    console.log '[Dropshop] Initialising...'
    @$doc = $(document)
    @$body = $('body')
    @init()

  init: ->
    @setWidths()
    @onPageLoad()
    ###
    Add Test for ios and Android
    Modernizr.addTest 'ios', ->
      return !!navigator.userAgent.match(/(iPad|iPhone|iPod)/g)
    Modernizr.addTest 'android', ->
      return !!navigator.userAgent.match(/(android)/g)
    ###

  onPageLoad: ->
    console.log '[Dropshop] onPageLoad'
    @setEventListeners()
    $('.hero').css
      'max-height' : @sizes.windowHeight - (@sizes.headerHeight + @windowHeightMargin)
    @$allMods = $("[data-animate]")

  setWidths:->
    console.log '[Dropshop] setting page dims'
    @sizes = 
      windowWidth: $(window).width()
      windowHeight: $(window).height()
      headerHeight: $('header.header').outerHeight()
    @isMobile = @sizes.windowWidth < 580


  onScroll: ->
    window.ticking = false
    unless dropshop.isMobile
      if window.latestKnownScrollY > dropshop.sizes.headerHeight
        dropshop.$body.addClass 'scrolled'
      else
        dropshop.$body.removeClass 'scrolled'

    # Animate elements on scroll when visible
    dropshop.$allMods.each (i, el) ->
      el = $(el)
      el.addClass 'animate' if el.visible(true)
    return

  setEventListeners: ->
    console.log '[Dropshop] setting event listeners'

    # @$doc.on 'click', '.expand-text', ->
    #   $(this).parent().toggleClass 'expanded'
    #   false

    @$doc.on 'click', 'a#menu-toggle', ->
      dropshop.$body.toggleClass 'slide-from-right'
      false

