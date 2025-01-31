<aside data-css-sidebar="sidebar">
  <form data-css-form="filter" data-js-form="filter">
    <h2 data-css-form="title">Filter realisations</h2>
    <fieldset data-css-form="group">
      <label data-css-form="label" for="realisation-title">Search by title</label>
      <input data-css-form="input" type="text" id="realisation-title" name="realisation-title" placeholder="Avengers: Infinity War">
    </fieldset>
    <fieldset data-css-form="group">
      <label data-css-form="label" for="realisation-genre">Genre</label>
      <?php
      $genres = get_terms( array(
          'taxonomy' => 'genre',
          'hide_empty' => false,
      ) );
      ?>
      <select data-css-form="input select" id="realisation-genre" name="realisation-genre">
        <option>Select genre</option>
        <?php foreach($genres as $genre) : ?>
        <option value="<?= $genre->term_id; ?>"><?= $genre->name; ?></option>
        <?php endforeach; ?>
      </select>
    </fieldset>
    <fieldset data-css-form="group">
      <label data-css-form="label">Keywords</label>
      <?php
      $keywords = get_terms( array(
          'taxonomy' => 'keyword',
          'hide_empty' => false,
      ) );
      foreach($keywords as $keyword) :
      ?>
      <div data-css-form="input-group">
        <input type="checkbox" id="<?= $keyword->slug; ?>" name="realisation-keywords[]" value="<?= $keyword->term_id; ?>"><label for="<?= $keyword->slug; ?>"><?= $keyword->name; ?></label>
      </div>
      <?php endforeach; ?>
    </fieldset>
    <fieldset data-css-form="group">
      <label data-css-form="label" for="realisation-order">Order by</label>
      <select data-css-form="input select" id="realisation-order" name="realisation-order">
        <option value="">List Order</option>
        <option value="Popularity">Popularity</option>
        <option value="Alphabetical">Alphabetical</option>
      </select>
    </fieldset>
    <fieldset data-css-form="group right">
      <button data-css-button="button red">Filter</button>
      <input type="hidden" name="action" value="filter">
    </fieldset>
  </form>
</aside>