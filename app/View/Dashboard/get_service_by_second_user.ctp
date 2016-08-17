  <select class="form-control" id="serviceSchedule">
                                <option value="0" selected>Serviço</option>
								<?php ?>
                                <?php
                                if (isset($services)) {
                                    foreach ($services as $sevice) {
                                        echo '<option value="' . $sevice['services']['id'] . '">' . utf8_encode($sevice['subclasses']['name']) . '</option>';
                                    }
                                }
                                ?>
                            </select>