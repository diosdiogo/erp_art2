<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-green">
        <span class="info-box-icon"><i class="glyphicon glyphicon-plus-sign"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">RECEITAS</span>
            <span class="info-box-number">{{$grid['receita']}}</span>

            <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
            </div>
                <span class="progress-description">
               
                </span>
        </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="glyphicon glyphicon-minus-sign"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">DESPESAS</span>
                <span class="info-box-number">{{$grid['despesa']}}</span>

                <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
                </div>
                    <span class="progress-description">
                    </span>
            </div>
        </div>
     </div>
     <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-aqua">
        <span class="info-box-icon"><i class="glyphicon glyphicon-ok-circle"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">TOTAL</span>
            <span class="info-box-number">{{$grid['total']}}</span>
            <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
            </div>
                <span class="progress-description">
                </span>
        </div>
        </div>
    </div>
</div>